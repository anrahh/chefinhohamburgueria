import moment from 'moment';

const isEmail = (email) => {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

const isEmpty = (value) => {
    return (value == undefined ||value.trim().length == 0);
}
const dateBr = (value) => {
    return moment(value).format('DD/MM/YYYY HH:mm:ss');
}
export  {
    isEmail,
    isEmpty,
    dateBr
}
