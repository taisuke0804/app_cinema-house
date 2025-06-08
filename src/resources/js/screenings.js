
document.addEventListener('DOMContentLoaded', function () {

  const seatButtons = document.querySelectorAll('.seat-not-reserve');
  const reserveButton = document.getElementById('reserve-btn');
  const selectedSeatText = document.getElementById('select-seat');

  seatButtons.forEach(button => {
    button.addEventListener('click', function () {
      const seatId = this.dataset.seatId;

      if (this.classList.contains('seat-selected')) {
        this.classList.remove('seat-selected');
        selectedSeatText.textContent = `座席が選択されていません。`;
        reserveButton.disabled = true;
      } else {
        document.querySelectorAll('.seat-selected').forEach(otherSeat => {
          otherSeat.classList.remove('seat-selected');
          console.log('uuu');
        });
        this.classList.add('seat-selected');

        const row = this.dataset.row;
        const number = this.dataset.number;

        selectedSeatText.textContent = `選択した座席: ${row}${number}`;
        reserveButton.disabled = false;
      }

      // console.log(seatId);
    });
  });
  
});