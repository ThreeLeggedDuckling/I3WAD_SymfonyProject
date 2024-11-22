import('./styles/validUsername.css');

let usernameField = document.getElementById('registration_form_username');
let reg = new RegExp(usernameField.getAttribute('pattern'));

usernameField.addEventListener('focusout', () => {
    axios.post('/register/verifyusername', usernameField.value)
        .then(response => {
            if (typeof response.data.available !== 'undefined') {
                // nettoyer modifications précédentes
                if (usernameField.nextElementSibling !== null) {
                    usernameField.classList.remove('taken');
                    usernameField.nextElementSibling.remove();
                }

                if (usernameField.value.length > 0) {
                    let span = document.createElement('span');
                    usernameField.parentElement.append(span);
                    span.style.color = "red";

                    if (usernameField.value.length < 3) {
                        span.textContent = "username can only contains alphanumerics, dashes and underscores"
                    } else if (reg.test(usernameField.value)) {
                        if (!response.data.available) {
                            usernameField.classList.add('taken');
                            span.textContent = "username already taken";
                        }
                    } else {
                        span.textContent = "username can only contains alphanumerics, dashes and underscores"
                    }
                }
            }
        })
})




//// code exemple recherche ajax livres

// const form = document.getElementById('search_form');
// const resultsDiv = document.getElementById('results');
// form.addEventListener('input', function(){
//     // console.log('truc tapé');
//     let formData = new FormData(form);
//     axios.post('/livres/search', formData)
//         .then(response => {
//             // debug
//             // if (response.data.length == 0) {
//             //     console.log('aucun résultat');
//             // } else{
//             //     console.log(response.data); // parse effectué par axios
//             // }
//             let booksArr = response.data;

//             resultsDiv.innerHTML = "";
//             let ul = document.createElement('ul');
//             for(i in booksArr){
//                 let li = document.createElement('li');
//                 li.innerText = booksArr[i].titre + " (" + booksArr[i].prix + ")";
//                 ul.appendChild(li);
//             }
//             resultsDiv.appendChild(ul);
//         })
// })