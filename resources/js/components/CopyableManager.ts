/**
 * Copyable Manager
 *
 * Handles copy-to-clipboard functionality for infolist entries.
 */

import type { CopyableElement } from '../types';

export class CopyableManager {
    private static instances = new WeakMap<HTMLElement, CopyableManager>();
    private element: CopyableElement;
    private copyValue: string;
    private copyMessage: string;
    private copyMessageDuration: number;
    private trigger: HTMLElement | null = null;
    private originalContent: string | null = null;

    constructor(element: CopyableElement) {
        this.element = element;
        this.copyValue = element.dataset.copyValue || '';
        this.copyMessage = element.dataset.copyMessage || 'Copied!';
        this.copyMessageDuration = parseInt(element.dataset.copyMessageDuration || '2000', 10);

        this.init();
    }

    private init(): void {
        // Find the trigger button if it exists
        this.trigger = this.element.querySelector('[data-copy-trigger]');

        if (this.trigger) {
            this.trigger.addEventListener('click', this.handleCopy.bind(this));
        } else {
            // If no trigger, the whole element is clickable
            this.element.addEventListener('click', this.handleCopy.bind(this));
        }
    }

    private async handleCopy(event: Event): Promise<void> {
        event.preventDefault();
        event.stopPropagation();

        try {
            await navigator.clipboard.writeText(this.copyValue);
            this.showFeedback();
        } catch (error) {
            // Fallback for older browsers
            this.fallbackCopy();
        }
    }

    private fallbackCopy(): void {
        const textarea = document.createElement('textarea');
        textarea.value = this.copyValue;
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            this.showFeedback();
        } catch {
            console.error('Failed to copy text');
        }

        document.body.removeChild(textarea);
    }

    private showFeedback(): void {
        const target = this.trigger || this.element;

        // Store original content
        if (this.trigger) {
            this.originalContent = this.trigger.innerHTML;
            this.trigger.innerHTML = `
                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            `;
        } else {
            // Show tooltip-style message
            const message = document.createElement('span');
            message.className = 'absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg whitespace-nowrap';
            message.textContent = this.copyMessage;
            message.setAttribute('data-copy-feedback', '');

            this.element.style.position = 'relative';
            this.element.appendChild(message);
        }

        // Restore after duration
        setTimeout(() => {
            if (this.trigger && this.originalContent) {
                this.trigger.innerHTML = this.originalContent;
            } else {
                const message = this.element.querySelector('[data-copy-feedback]');
                if (message) {
                    message.remove();
                }
            }
        }, this.copyMessageDuration);
    }

    public destroy(): void {
        if (this.trigger) {
            this.trigger.removeEventListener('click', this.handleCopy.bind(this));
        } else {
            this.element.removeEventListener('click', this.handleCopy.bind(this));
        }

        CopyableManager.instances.delete(this.element);
    }

    /**
     * Initialize all copyable elements on the page
     */
    public static initAll(): void {
        const elements = document.querySelectorAll<CopyableElement>('[data-copyable]');

        elements.forEach((element) => {
            if (!CopyableManager.instances.has(element)) {
                const instance = new CopyableManager(element);
                CopyableManager.instances.set(element, instance);
            }
        });
    }

    /**
     * Get instance for an element
     */
    public static getInstance(element: HTMLElement): CopyableManager | undefined {
        return CopyableManager.instances.get(element);
    }
}
