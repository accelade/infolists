/**
 * Accelade Infolist - TypeScript Entry Point
 *
 * Provides enhanced functionality for infolist components.
 * Integrates with Accelade's event system for SPA navigation.
 */

// Import CSS for bundling
import '../css/infolist.css';

// Component modules
export { CopyableManager } from './components/CopyableManager';

// Types
export type { InfolistConfig, CopyableElement } from './types';

// Main initialization
import { initInfolist, reinitInfolist } from './init';

export { initInfolist, reinitInfolist };

// Auto-initialize
if (typeof window !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInfolist);
    } else {
        initInfolist();
    }

    // Re-initialize on Accelade navigation events
    document.addEventListener('accelade:navigated', reinitInfolist);
    document.addEventListener('accelade:updated', reinitInfolist);
}
