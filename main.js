const input_order = document.getElementById('Input-Order');
const random = document.getElementById('Random');
const view = document.getElementById('View');

random.addEventListener('click', () => {
        const max = Number(input_order.value); // แปลงค่า input เป็นตัวเลข
        if (isNaN(max) || max <= 0) {
                view.textContent = "กรุณาใส่ตัวเลขที่มากกว่า 0";
                return;
        }
        
        const rand = Math.floor(Math.random() * max) + 1; // สุ่มเลข 1 - max
        view.textContent = "เลขสุ่ม: " + rand;
});