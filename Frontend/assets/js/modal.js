function initModal() {

    const modal = document.getElementById("carModal");
    const closeModal = document.querySelector(".close");

    const modalTitle = document.getElementById("modal-title");
    const modalImage = document.getElementById("modal-image");
    const modalBrand = document.getElementById("modal-brand");
    const modalModel = document.getElementById("modal-model");
    const modalYear = document.getElementById("modal-year");
    const modalPrice = document.getElementById("modal-price");
    const modalEngine = document.getElementById("modal-engine");
    const modalHorsepower = document.getElementById("modal-horsepower");
    const modalTorque = document.getElementById("modal-torque");
    const modalAcceleration = document.getElementById("modal-acceleration");
    const modalTopSpeed = document.getElementById("modal-top-speed");

    const carDetails = {
        "Lamborghini Huracan": {
            img: "./assets/img/offer-14.jpg",
            brand: "Lamborghini",
            model: "Huracan",
            year: 2022,
            price: "$215 per day",
            engine: "5.2L V10",
            horsepower: 631,
            torque: 600,
            acceleration: 2.9,
            top_speed: 325
        },
        "Ferrari SF90 Stradale": {
            img: "./assets/img/offer-1.jpg",
            brand: "Ferrari",
            model: "SF90 Stradale",
            year: 2023,
            price: "$400 per day",
            engine: "4.0L V8 Hybrid",
            horsepower: 986,
            torque: 800,
            acceleration: 2.5,
            top_speed: 340
        },
        "Audi e-Tron GT": {
        img: "./assets/img/offer-2.jpg",
        brand: "Audi",
        model: "e-Tron GT",
        year: 2022,
        price: "$250 per day",
        engine: "Dual Electric Motor",
        horsepower: 637,
        torque: 830,
        acceleration: 3.1,
        top_speed: 245
        },

        "Porsche 911": {
        img: "./assets/img/offer-3.jpg",
        brand: "Porsche",
        model: "911 Carrera 4S",
        year: 2023,
        price: "$300 per day",
        engine: "3.0L Twin-Turbo Flat-6",
        horsepower: 443,
        torque: 530,
        acceleration: 3.4,
        top_speed: 308
        }
    };

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("details")) {
            event.preventDefault(); 
            event.stopPropagation();

            const carName = event.target.closest(".car_box").querySelector("h3").innerText;

            if (carDetails[carName]) {
                modalTitle.innerText = carName;
                modalImage.src = carDetails[carName].img;
                modalBrand.innerText = carDetails[carName].brand;
                modalModel.innerText = carDetails[carName].model;
                modalYear.innerText = carDetails[carName].year;
                modalPrice.innerText = carDetails[carName].price;
                modalEngine.innerText = carDetails[carName].engine;
                modalHorsepower.innerText = carDetails[carName].horsepower;
                modalTorque.innerText = carDetails[carName].torque;
                modalAcceleration.innerText = carDetails[carName].acceleration;
                modalTopSpeed.innerText = carDetails[carName].top_speed;

                modal.classList.add("show");
            }
        }
    });

    closeModal.addEventListener("click", function () {
        modal.classList.remove("show");
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("show");
        }
    });
}
