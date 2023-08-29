const form = document.getElementsByTagName("form")[0];
// const submitBtn = document.getElementById('submit-btn');
//form values
const url = form.getAttribute('action');
const titleInput = document.getElementById('title');
const tagInput  = document.getElementById('tags');
const dateInput = document.getElementById('date');
const statusProductInput = document.getElementById('status');
const userReviewsInput = document.getElementById('userReviews');
// const priceInput = document.getElementById('price');
const stockInput = document.getElementById('stock');
const aboutInput = document.getElementById('about');
const imgInput   = document.getElementById('product-img');
let errMsg = document.getElementById('err');





function findBaseUrl(urlToParse){
    let result = urlToParse.split('/');
    result = '/'+result[1]+'/'+result[2];
    return result;
}