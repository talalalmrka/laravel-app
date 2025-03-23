import { initFadgramUI } from "fadgram-ui/helpers";
document.addEventListener('livewire:navigated', () => {
  initFadgramUI();
});