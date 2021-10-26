// thao tác update info user

var button_modify = document.querySelector('.row_button button');
var count = 1;

var button_update = document.querySelector('#disabled');
button_modify.onclick = function (event){
    event.preventDefault();
    if(count %2 != 0){

    button_update.setAttribute('id', 'active');

    showForm();
    }else{
        let button_update = document.querySelector('#active');
        button_update.setAttribute('id', 'disabled');
        
        let p = document.querySelectorAll('.row p');
        let input = document.querySelectorAll('.row input');
        for(i=0; i<p.length; i++){
            p[i].style.display = 'block';
            input[i].style.display = 'none';
            button_update.disabled = true;
        }
        
    }
    count++;
};

function showForm(){
    let p = document.querySelectorAll('.row p');
    let input = document.querySelectorAll('.row input');
    for(i=0; i<p.length; i++){
        p[i].style.display = 'none';
        input[i].style.display = 'block';
        input[i].disabled =false;
    }
    button_update.disabled =false;
}

// update avatar user

var show_modal = document.getElementsByClassName('show_modal');
var count_modal =1;

show_modal[0].onclick = function () {
    if(count_modal %2 !=0){
        let img = document.getElementsByClassName('update_img');
        img[0].style.display = 'block';
    }
}
var hide_modal = document.getElementsByClassName('update_img');

window.onclick = function(event) {
    if (event.target == hide_modal[0]) {
      hide_modal[0].style.display = "none";
    }
  }