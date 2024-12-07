// window.onload = function () {
//    
//     document.getElementById('home-bg').classList.add('home-bg' + imgr);
// };


var description = [
    "<img src='img/bg/home-bg0.jpg' alt='home-bg0.jpg'>",
    "<img src='img/bg/home-bg1.jpg' alt='home-bg1.jpg'>",
    "<img src='img/bg/home-bg2.jpg' alt='home-bg2.jpg'>",
    "<img src='img/bg/home-bg3.jpg' alt='home-bg3.jpg'>",
    "<img src='img/bg/home-bg4.jpg' alt='home-bg4.jpg'>",
    "<img src='img/bg/home-bg5.jpg' alt='home-bg5.jpg'>",
    "<img src='img/bg/home-bg6.jpg' alt='home-bg6.jpg'>",
    "<img src='img/bg/home-bg7.jpg' alt='home-bg7.jpg'>",
    "<img src='img/bg/home-bg8.jpg' alt='home-bg8.jpg'>",
   
];
var size = description.length
var x = Math.floor(size * Math.random())
document.getElementById('home-bg').appendTo(description[x]);