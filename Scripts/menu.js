const menuData = {
    italian: [
        {
            name: "Italian Pasta",
            description: "Delicious homemade pasta with a rich tomato sauce and fresh basil.",
            image: "../Assets/pasta.jpg"
        },
        {
            name: "Margherita Pizza",
            description: "Classic pizza with fresh tomatoes, mozzarella, and basil.",
            image: "../Assets/menu/pizza.jpg"
        }
    ],
    sushi: [
        {
            name: "Sushi Platter",
            description: "Assorted sushi with fresh fish, served with soy sauce and wasabi.",
            image: "../Assets/menu/sushi_platter.jpg"
        },
        {
            name: "Salmon Nigiri",
            description: "Fresh salmon nigiri with a touch of wasabi.",
            image: "../Assets/menu/salmon-nigiri.jpg"
        }
    ],
    mexican: [
        {
            name: "Mexican Tacos",
            description: "Spicy chicken tacos with avocado, cilantro, and lime.",
            image: "../Assets/menu/mexican_tacos.jpg"
        },
        {
            name: "Guacamole",
            description: "Creamy guacamole made with ripe avocados, lime, and cilantro.",
            image: "../Assets/menu/guacamole.jpg"
        }
    ],
    french: [
        {
            name: "French Croissant",
            description: "Buttery croissants baked to perfection, served with jam and butter.",
            image: "../Assets/menu/french_croissant.jpg"
        },
        {
            name: "Quiche Lorraine",
            description: "Savory quiche with bacon, cheese, and onions.",
            image: "../Assets/menu/quiche_lorraine.jpg"
        }
    ],
    srilankan: [
        {
            name: "Sri Lankan Curry",
            description: "Spicy and flavorful curry with coconut milk and local spices.",
            image: "../Assets/menu/srilankan_curry.jpg"
        },
        {
            name: "Hoppers",
            description: "Traditional Sri Lankan bowl-shaped pancakes, served with curry.",
            image: "../Assets/menu/hoppers.jpg"
        }
    ],
    indian: [
        {
            name: "Butter Chicken",
            description: "Creamy and rich butter chicken with a blend of spices.",
            image: "../Assets/menu/butter_chicken.jpg"
        },
        {
            name: "Paneer Tikka",
            description: "Grilled paneer cubes marinated in spicy yogurt sauce.",
            image: "../Assets/menu/paneer_tikka.jpg"
        }
    ],
    chinese: [
        {
            name: "Sweet and Sour Chicken",
            description: "Crispy chicken in a tangy sweet and sour sauce.",
            image: "../Assets/menu/sweet_sour_chicken.jpg"
        },
        {
            name: "Spring Rolls",
            description: "Crispy spring rolls filled with vegetables and served with dipping sauce.",
            image: "../Assets/menu/spring_rolls.jpg"
        }
    ],
    thai: [
        {
            name: "Pad Thai",
            description: "Stir-fried noodles with shrimp, tofu, and a tangy tamarind sauce.",
            image: "../Assets/menu/pad_thai.jpg"
        },
        {
            name: "Green Curry",
            description: "Spicy and aromatic green curry with coconut milk and fresh herbs.",
            image: "../Assets/menu/green_curry.jpg"
        }
    ]
};

function showCuisine(cuisine) {
    const menuItems = document.getElementById("menu-items");
    menuItems.className = 'menu-items';
    menuItems.innerHTML = "";

    if (menuData[cuisine]) {
        menuData[cuisine].forEach(item => {
            const menuItem = document.createElement("div");
            menuItem.className = "menu-item";

            const menuItemDes = document.createElement("div")
            menuItemDes.className = 'menu-item-description';

            const img = document.createElement("img");
            img.src = item.image;
            img.alt = item.name;

            const colorOverlay = document.createElement("div");
            colorOverlay.className = 'color-overlay'

            const title = document.createElement("h2");
            title.textContent = item.name;

            const description = document.createElement("p");
            description.textContent = item.description;

            menuItemDes.appendChild(title)
            menuItemDes.appendChild(description)

            menuItem.appendChild(img);
            menuItem.appendChild(colorOverlay);
            menuItem.appendChild(menuItemDes);

            menuItems.appendChild(menuItem);
        });
    }
}
