/**
 * Browser bundle: exposes CKEditor config helpers for blade-loaded scripts.
 */
import { CKEDITOR_SHARED_CONFIG } from './toolbar';
import { buildCkeditorConfig } from './build-config';

window.__CKEDITOR_SHARED_CONFIG = CKEDITOR_SHARED_CONFIG;
window.buildCkeditorConfig = buildCkeditorConfig;
