const slider1 = document.getElementById("iv-blend-slider1");
const slider2 = document.getElementById("iv-blend-slider2");
const slider3 = document.getElementById("iv-blend-slider3");
const slider4 = document.getElementById("iv-blend-slider4");

const liquid1 = document.getElementById("iv-blend-liquid1");
const liquid2 = document.getElementById("iv-blend-liquid2");
const liquid3 = document.getElementById("iv-blend-liquid3");
const liquid4 = document.getElementById("iv-blend-liquid4");

const label1 = document.getElementById("iv-blend-label1");
const label2 = document.getElementById("iv-blend-label2");
const label3 = document.getElementById("iv-blend-label3");
const label4 = document.getElementById("iv-blend-label4");

slider1.addEventListener("input", function () {
    const totalValue = parseInt(this.value) + parseInt(slider2.value) + parseInt(slider3.value) + parseInt(slider4.value)
    const remainingValue = 100 - totalValue;

    if (remainingValue >= 0) {
        liquid1.style.height = this.value + "%";
        label1.textContent = Math.trunc(this.value) + "%";
    } else {
        const excessValue = Math.abs(remainingValue);
        const adjustedValue = parseInt(this.value) - excessValue;
        liquid1.style.height = adjustedValue + "%";
        this.value = adjustedValue;
        label1.textContent = Math.trunc(adjustedValue) + "%";
    }

});

slider2.addEventListener("input", function () {
    const totalValue = parseInt(slider1.value) + parseInt(this.value) + parseInt(slider3.value) + parseInt(slider4.value);
    const remainingValue = 100 - totalValue;

    if (remainingValue >= 0) {
        liquid2.style.height = this.value + "%";
        label2.textContent = Math.trunc(this.value) + "%";
    } else {
        const excessValue = Math.abs(remainingValue);
        const adjustedValue = parseInt(this.value) - excessValue;
        liquid2.style.height = adjustedValue + "%";
        this.value = adjustedValue;
        label2.textContent = Math.trunc(adjustedValue) + "%";
    }
});

slider3.addEventListener("input", function () {
    const totalValue = parseInt(slider1.value) + parseInt(slider2.value) + parseInt(this.value) + parseInt(slider4.value);
    const remainingValue = 100 - totalValue;

    if (remainingValue >= 0) {
        liquid3.style.height = this.value + "%";
        label3.textContent = Math.trunc(this.value) + "%";
    } else {
        const excessValue = Math.abs(remainingValue);
        const adjustedValue = parseInt(this.value) - excessValue;
        liquid3.style.height = adjustedValue + "%";
        this.value = adjustedValue;
        label3.textContent = Math.trunc(adjustedValue) + "%";
    }
});

slider4.addEventListener("input", function () {
    const totalValue = parseInt(slider1.value) + parseInt(slider2.value) + parseInt(slider3.value) + parseInt(this.value);
    const remainingValue = 100 - totalValue;

    if (remainingValue >= 0) {
        liquid4.style.height = this.value + "%";
        label4.textContent = Math.trunc(this.value) + "%";
    } else {
        const excessValue = Math.abs(remainingValue);
        const adjustedValue = parseInt(this.value) - excessValue;
        liquid4.style.height = adjustedValue + "%";
        this.value = adjustedValue;
        label4.textContent = Math.trunc(adjustedValue) + "%";
    }
});
