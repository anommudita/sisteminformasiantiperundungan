const loaderEnd = () => {
    const loader = document.querySelector('#loader');
    const img = loader.querySelector('img');
    document.body.classList.remove('vh-100');
    document.body.classList.remove('vw-100');
    document.body.classList.remove('overflow-hidden');;
    img.style.transform = "scale(2)";
    loader.style.opacity = "0";
    setTimeout(( ()=> {
        loader.classList.add('d-none');
        loader.remove();
        // console.log("yes")  
    }),1400)

}