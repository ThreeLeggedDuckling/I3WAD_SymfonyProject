import './styles/seeUser.css';

const userRefs = document.getElementsByClassName('userPL');
let users = [];
for (const u of userRefs) {
    users.push(u.textContent);
}

console.log('userRefs :>> ', userRefs);
console.log('users :>> ', users);