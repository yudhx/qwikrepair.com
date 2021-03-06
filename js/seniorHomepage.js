var greetDate = document.getElementById("greetDate");
if (greetDate != null) {
    date = new Date()
    greetDate.innerHTML = getDay(date) + ", " + getDate(date) + " " + getMonth(date);
}

function getDate(date) {
    return String(date.getDate());
}

function getMonth(date) {
    month = ["January","February","March","April","May","June","July","August","September","October","November","December"]
    return month[date.getMonth() + 1]    
}

function getDay(date) {
    day = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
    return day[date.getDay()]
}

function Appointment(techPic, serviceName, techName, redirectUrl) {
    this.techPic = techPic;
    this.serviceName = serviceName;
    this.techName = techName;
    this.redirectUrl = redirectUrl;
    this.card = `
        <div class="appo-card">
            <img class="appo-tech-pic" src="${this.techPic}" alt="src/profile.svg">
            <div class="appo-title font-medium">${this.serviceName}</div>
            <div class="appo-tech-name font-small">${this.techName}</div>
            <a class="btn btn-blue appo-book-again" href="${this.redirectUrl}">Book</a>
        </div>
    `
}

function displayPastAppoCard(appointmentArray) {
    pastAppoCardWrap = document.getElementById("pastAppoCardWrap");
    if (pastAppoCardWrap != null) {
        length = appointmentArray.length;
        if (length > 0) {
            for (i=0; (i < length && i < 4); i++) {
                pastAppoCardWrap.innerHTML += appointmentArray[i].card;
            } 
        } else {
            pastAppoCardWrap.innerHTML = "No recent appointment found.";
        }
    }
}

function displayInstantAppo(serviceArray) {
    instList = document.getElementById("instList");
    if (instList != null) {
        length = serviceArray.length;
        if (length > 0) {
            for (i=0; (i < length && i < 4); i++) {
                html = `
                <div class="inst-wrapper">
                    <div class="inst-name">${serviceArray[i]}</div>
                    <img src="src/add.svg">
                </div>
                `
                instList.innerHTML += html;
            }
        } else {
            serviceArray.innerHTML = "No available service found.";
        }
    }
}

var appointmentArray = [];

function getBriefAppointmentHistory() {
    let formData = new FormData();
    formData.append("request-type", "getBriefAppointmentHistory");
    fetch('api/crudHandler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data[0].serviceName);
        for (var i=0; i < data.length; i++) {
            serviceName = data[i].serviceName;
            fullName = data[i].fullName;
            appointmentArray.push('new Appointment("src/profile.svg", serviceName, fullName, ""');
        }
    })
    return appointmentArray; 
}


displayPastAppoCard(appointmentArray);

serviceArray = ['Aircon Service', 'Dust Clean', 'Plumbing'];

displayInstantAppo(serviceArray);