import './styles/answerComment.css';

let answerBtn = document.getElementsByClassName('answerTo');
let answerToField = document.getElementById('comment_answering');
let answerHelp = document.getElementById('answerHelp');
let textarea = document.getElementById('comment_content');
let comment, answerValue, toThread, toUser;


for (const btn of answerBtn) {
    btn.addEventListener('click', () => {
        // attribution valeur answerTo
        comment = btn.parentElement;
        answerValue = comment.id[0] === 'a' ? comment.parentElement.id.substring(1) : comment.id;

        answerToField.value = answerValue;
        // debug
        // console.log('______');
        // console.log('comment :>> ', comment.id);
        // console.log('>>> new answerTo value :>> ', answerToField.value);
        
        // ajout indication réponse
        if (answerToField.value == null) {
            console.log('answerToField.value == null :>> ', answerToField.value == null);
            answerHelp.hidden = true;
            answerHelp.innerHTML = '';
        }
        else {

            toUser = comment.innerText.split(' ')[0];
            if (comment.id != answerToField.value) {
                toThread = document.getElementById(answerToField.value).innerText.split(' ')[0];
                // debug
                // console.log('toThread :>> ', toThread);

                answerHelp.innerHTML = `🗨️ answering to a <a href='#${answerValue}'>comment</a> in a thread <button id="cancelA">❌</button>`;
                // nettoyage @user déjà présent
                let splited = textarea.value.split(' ');
                if (splited[0][0] == '@') {
                    // debug
                    // console.log('>>> @ déjà présent');
                    // console.log('ternary :>> ', splited[1] == "");

                    textarea.value = splited[1] == "" ? '' : textarea.value.replace(`${splited[0]} `, '');
                }
                textarea.value = `@${toUser} ` + textarea.value;
            }
            else {
                answerHelp.innerHTML = `🗨️ answering to ${toUser}'s <a href='#${answerValue}'>comment</a> <button id="cancelA">❌</button>`;
            }
            // debug
            // console.log('toUser :>> ', toUser);
            
            answerHelp.hidden = false;

            // annuler réponse
            let cancelBtn = document.getElementById('cancelA');
            cancelBtn.addEventListener('click', () => {
                // reset value
                answerToField.value = null;

                //nettoyage
                answerHelp.hidden = true;
                answerHelp.innerHTML = '';
                let splited = textarea.value.split(' ');
                if (splited[0][0] == '@') {
                    textarea.value = splited[1] == "" ? '' : textarea.value.replace(`${splited[0]} `, '');
                }

                // debug
                // console.log('answerToField.value :>> ', answerToField.value);
            })
        }

    })

}
