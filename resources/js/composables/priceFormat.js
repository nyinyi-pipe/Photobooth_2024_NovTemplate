const priceFormat = (x) => {
    return parseInt(x).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " Ks";
}

export default priceFormat;