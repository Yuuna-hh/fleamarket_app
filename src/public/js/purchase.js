document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('paymentSelect');
    const label = document.getElementById('paymentLabel');
    const buyButton = document.getElementById('buyButton');
    const hiddenSubmit = document.getElementById('hiddenSubmit');

    if (!select || !label || !buyButton || !hiddenSubmit) return;

    const updatePaymentLabel = () => {
        if (select.value === 'convenience') {
        label.textContent = 'コンビニ支払い';
        } else if (select.value === 'card') {
        label.textContent = 'カード支払い';
        } else {
        label.textContent = '未選択';
        }
    };

    select.addEventListener('change', updatePaymentLabel);

    buyButton.addEventListener('click', () => {
        if (!select.value) {
            select.focus();
        }
        hiddenSubmit.click();
    });
});
