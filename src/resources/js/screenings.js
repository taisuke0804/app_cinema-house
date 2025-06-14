
document.addEventListener('DOMContentLoaded', function () {

  const seatButtons = document.querySelectorAll('.seat-not-reserve');
  const reserveButton = document.getElementById('reserve-btn');
  const selectedSeatText = document.getElementById('select-seat');
  const modalOverlay = document.getElementById('modalOverlay');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const cancelBtn = document.getElementById('cancelBtn');
  const modalSeatInfo = document.getElementById('modalSeatInfo');

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
        });
        this.classList.add('seat-selected');

        const row = this.dataset.row;
        const number = this.dataset.number;

        selectedSeatText.textContent = `選択した座席: ${row}${number}`;
        modalSeatInfo.textContent = `選択した座席: ${row}${number}`;
        document.getElementById('modal-row').value = row;
        document.getElementById('modal-number').value = number;

        reserveButton.disabled = false;
      }

    });
  });
  
  reserveButton.addEventListener('click', () => modalOverlay.style.display = 'flex');
  closeModalBtn.addEventListener('click', () => modalOverlay.style.display = 'none');
  cancelBtn.addEventListener('click', () => modalOverlay.style.display = 'none');

  // 背景（modalOverlay）の外側をクリックしたら閉じる
  modalOverlay.addEventListener('click', function (e) {
    if (e.target === modalOverlay) {
      modalOverlay.style.display = 'none';
    }
  });
});