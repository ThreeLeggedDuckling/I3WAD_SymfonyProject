import './styles/answerComment.css';

let answerBtn = document.getElementsByClassName('answerTo');
let answerToField = document.getElementById('comment_answering');

console.log('test');
console.log(answerBtn);

for (const btn of answerBtn) {
    btn.addEventListener('click', () => {
        console.log('btn clicked');
        console.log('parent id :>> ', btn.parentElement.id);
        console.log('aT value :>> ', answerToField.value);
        answerToField.value = btn.parentElement.id;
        console.log('new aT value :>> ', answerToField.value);
    })
}