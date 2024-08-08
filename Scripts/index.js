const carouselData = new Array();
carouselData.push({
  imgSrc: "./Assets/coffee-shop.jpg",
  innerHTML: {
    title: "Welcome to Our Café",
    description: "Experience the best coffee in town.",
  },
});
carouselData.push({
  imgSrc: "./Assets/coffee-shop2.jpg",
  innerHTML: {
    title: "Delicious Treats",
    description: "Enjoy a variety of freshly baked goods.",
  },
});
carouselData.push({
  imgSrc: "./Assets/coffee-shop3.jpg",
  innerHTML: {
    title: "Cozy Ambiance",
    description: "Relax in our cozy and artistic atmosphere.",
  },
});
carouselData.push({
  imgSrc: "./Assets/sushi.jpg",
  innerHTML: {
    title: "Featured Items",
    description:
      " Explore our selection of featured items. Discover popular products and special offers highlighted just for you. Swipe through to find your next favorite!",
  },
});

document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.getElementById("carousel");
  carousel.className = "carousel";

  const leftBtn = document.getElementById("left");
  const rightBtn = document.getElementById("right");

  //Global Variables
  let currentIndex = 0;

  function childAppender(imageSrc, innerHTML) {
    if (!(imageSrc && innerHTML)) {
      console.warn("Either imageSrc or innerHTML is missing!");
      return;
    }

    const img = document.createElement("img");
    img.src = imageSrc;
    img.className = "carouselImage";

    const textComponent = document.createElement("div");
    textComponent.className = "carouselImageInnerHTML";

    const title = document.createElement("h2");
    title.innerHTML = innerHTML.title;
    const description = document.createElement("p");
    description.innerHTML = innerHTML.description;

    textComponent.appendChild(title);
    textComponent.appendChild(description);

    // Clear previous image
    carousel.innerHTML = "";

    carousel.appendChild(img);
    carousel.appendChild(textComponent);
  }

  function showNextImage() {
    currentIndex = (currentIndex + 1) % carouselData.length;
    const element = carouselData[currentIndex];
    childAppender(element.imgSrc, element.innerHTML);
  }

  function showPreviousImage() {
    currentIndex =
      (currentIndex - 1 + carouselData.length) % carouselData.length;
    const element = carouselData[currentIndex];
    childAppender(element.imgSrc, element.innerHTML);
  }

  function idle() {
    showNextImage();
    setInterval(showNextImage, 5000); // Change image every 5 seconds
  }

  idle();

  leftBtn.onclick = () => {
    showPreviousImage();
  };

  rightBtn.onclick = () => {
    showNextImage();
  };
});
