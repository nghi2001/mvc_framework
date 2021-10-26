window.onscroll = function (){
    scrollMenu();
    scrollToTop();
};

// create sticky menu
var nav = document.getElementById("nav");
var sticky = nav.offsetTop;

function scrollMenu(){
    if(window.pageYOffset > sticky){
        nav.classList.add('sticky');
    }else{
        nav.classList.remove('sticky');
    }
}

// create roll to top button

var roll = document.getElementById('roll_to_top');

function scrollToTop (){
    if(document.body.scrollTop >20 || document.documentElement.scrollTop >20){
        roll.style.display = "block";
    }else{
        roll.style.display = "none";
    }
}

roll.addEventListener('click', function () {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;   
})