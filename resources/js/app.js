import { initFadgramUI } from "fadgram-ui/helpers";
import Toast from "fadgram-ui/helpers/toast";
document.addEventListener('livewire:navigated', () => {
    initFadgramUI();
});
let toastListener = null;
let openNewTabListener = null;
document.addEventListener('livewire:init', () => {
    if (!toastListener) {
        toastListener = Livewire.on('toast', (event) => {
            const data = event[0];
            Toast.make(data.message, data.options);
        });
    }
});
//import "./textarea-direction";
