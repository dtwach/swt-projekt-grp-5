const rating = document.querySelector('input[type="number"]');
rating.addEventListener("change", validateMax);

function validateMax() {
  const num = typeof +this.value;
  if (this.value > +this.max) {
    this.value = this.max;
  }

  if (this.value < +this.min) {
    this.value = this.min;
  }
}
