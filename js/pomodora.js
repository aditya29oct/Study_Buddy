let timer;
let isRunning = false;
let isBreak = false;
let workDuration = 25 * 60; // 25 minutes
let breakDuration = 5 * 60; // 5 minutes
let timeLeft = workDuration;
let startTime;

const timerDisplay = document.getElementById("timer");
const startBtn = document.getElementById("startBtn");
const pauseBtn = document.getElementById("pauseBtn");
const resetBtn = document.getElementById("resetBtn");

function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

function updateDisplay() {
    timerDisplay.textContent = formatTime(timeLeft);
}

function startTimer() {
    if (!isRunning) {
        isRunning = true;
        startTime = Date.now();
        timer = setInterval(() => {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            timeLeft--;

            if (timeLeft <= 0) {
                clearInterval(timer);
                isRunning = false;

                let sessionDuration = isBreak ? breakDuration : workDuration;
                saveSession(sessionDuration / 60); // send minutes

                if (!isBreak) {
                    isBreak = true;
                    timeLeft = breakDuration;
                    alert("🎉 Work session complete! Take a break.");
                } else {
                    isBreak = false;
                    timeLeft = workDuration;
                    alert("🔔 Break over! Back to work.");
                }
                updateDisplay();
            } else {
                updateDisplay();
            }
        }, 1000);
    }
}

function pauseTimer() {
    clearInterval(timer);
    isRunning = false;
}

function resetTimer() {
    clearInterval(timer);
    isRunning = false;
    isBreak = false;
    timeLeft = workDuration;
    updateDisplay();
}

function saveSession(minutes) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/save-session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`user_id=${userId}&duration=${minutes}`);
}

startBtn.addEventListener("click", startTimer);
pauseBtn.addEventListener("click", pauseTimer);
resetBtn.addEventListener("click", resetTimer);

updateDisplay();
