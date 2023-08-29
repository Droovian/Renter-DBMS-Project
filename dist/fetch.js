
const fetch_button = document.getElementById("fetch-btn");

var requestOptions = {
    method: 'GET',
};

fetch_button.addEventListener("click", () => {

    const geoapiKey = '7dacd17594f3471b83275660c476b5bc';
    const url = `https://api.geoapify.com/v1/ipinfo?&apiKey=${geoapiKey}`;

    fetch(url, requestOptions).then(res => res.json()).then(data => {

        const state = data.state.name;
        const latitude = data.location.latitude;
        const longitude = data.location.longitude;

        console.log(`You belong to ${state}\nLatitude:${latitude}\nLongitude:${longitude}`);
        // console.log(data);
    }).catch(() => {
        console.log("Error fetching data from api");
    })

})

