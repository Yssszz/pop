const main = document.querySelector(".main");
const img = document.querySelector("#char");
const score = document.querySelector("#score");
const audio = new Audio("assets/pop.mp3");

let currentClosed = img.dataset.closed;   
let currentOpen = img.dataset.open;      

audio.volume = 0.2;
let count = Number(score.textContent);
let canPop = true;

function pop() {
    if (canPop) {
        img.src = currentOpen;    
        audio.currentTime = 0;
        audio.play();
        count = count + 1;
        score.textContent = count;
        canPop = false;
        fetch("add_score.php");
    }
}

function unpop() {
    img.src = currentClosed;   
    canPop = true;
}

main.addEventListener("mousedown", pop);
main.addEventListener("mouseup", unpop);

document.addEventListener("keydown", function(event) {
    if (event.code === "Space" || event.key === " ") {
        event.preventDefault(); 
        pop();
    }
});

document.addEventListener("keyup", function(event) {
    if (event.code === "Space" || event.key === " ") {
        unpop();
    }
});