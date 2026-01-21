import './bootstrap';
import * as Turbo from "@hotwired/turbo";

document.addEventListener('turbo:before-fetch-request', () => {
    document.body.style.cursor = 'progress';
});

document.addEventListener('turbo:before-fetch-response', () => {
    document.body.style.cursor = 'default';
});
