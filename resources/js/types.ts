/**
 * Infolist configuration types
 */

export interface InfolistConfig {
    copyMessage?: string;
    copyMessageDuration?: number;
}

export interface CopyableElement extends HTMLElement {
    dataset: DOMStringMap & {
        copyValue?: string;
        copyMessage?: string;
        copyMessageDuration?: string;
    };
}

declare global {
    interface Window {
        AcceladeInfolist?: {
            init: () => void;
            reinit: () => void;
            Copyable: typeof import('./components/CopyableManager').CopyableManager;
        };
    }
}
