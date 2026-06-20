const main = document.querySelector(".main"); //main click
const img = document.querySelector("#char"); // hamster image
const score = document.querySelector("#score"); // score
const audio = new Audio("assets/pop.mp3"); // sound effect

let currentClosed = img.dataset.closed;   // hamster close
let currentOpen = img.dataset.open;      // hasmter pop

audio.volume = 0.2; //audio volume
let count = Number(score.textContent); //change text to real number
let canPop = true; //boolean check can pop or not.

function pop() { //我的pop function
    if (canPop) { //如果can pop
        img.src = currentOpen;     //change pop hamster image
        audio.currentTime = 0; //reset audio to start 0s.
        audio.play(); //play audio
        count = count + 1; //score + 1
        score.textContent = count; //shOw newest update score
        canPop = false; //关boolean 防止刷分
        fetch("add_score.php"); //tell add score php
    }
}

function unpop() {
    img.src = currentClosed; //change back to close hamster
    canPop = true; //can pop again
}

main.addEventListener("mousedown", pop); //监听mouse click
main.addEventListener("mouseup", unpop); // 监听mouse 松手

document.addEventListener("keydown", function(event) { // 监听keyboard
    if (event.code === "Space" || event.key === " ") { //if按的是spAce
        event.preventDefault(); //dont let screen scroll down
        pop(); //我的pop function
    }
});

document.addEventListener("keyup", function(event) {
    if (event.code === "Space" || event.key === " ") {
        unpop();
    }
});