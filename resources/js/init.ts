/**
 * Infolist initialization
 */

import { CopyableManager } from './components/CopyableManager';

/**
 * Initialize all infolist components
 */
export function initInfolist(): void {
    CopyableManager.initAll();
}

/**
 * Re-initialize infolist (for SPA navigation)
 */
export function reinitInfolist(): void {
    initInfolist();
}

/**
 * Expose infolist API globally
 */
if (typeof window !== 'undefined') {
    (window as any).AcceladeInfolist = {
        init: initInfolist,
        reinit: reinitInfolist,
        Copyable: CopyableManager,
    };
}
