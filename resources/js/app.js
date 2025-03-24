import { initFadgramUI } from "fadgram-ui/helpers";
import Toast from "fadgram-ui/helpers/toast";
document.addEventListener('livewire:navigated', () => {
  initFadgramUI();
})
document.addEventListener('livewire:init', () => {
  let toastListener = Livewire.on('toast', (event) => {
    const data = event[0];
    Toast.make(data.message, data.options);
  });
  toastListener.cleanup = () => {
    Livewire.off('toast', toastListener);
  };
});
//import "./textarea-direction";