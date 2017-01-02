/**
 * Module for connection
 *
 * @author from https://www.kirupa.com/html5/check_if_internet_connection_exists_in_javascript.htm
 */

 function doesConnectionExist() {
    var xhr = new XMLHttpRequest();
    var file = "http://www.google.com.ph"; // Resolve using the VPN website deployed for teh CART WEB Application
    var randomNum = Math.round(Math.random() * 10000);
     
    xhr.open('HEAD', file + "?rand=" + randomNum, false);
     
    try {
        xhr.send();
         
        if (xhr.status >= 200 && xhr.status < 304) {
            return true;
        } else {
            return false;
        }
    } catch (e) {
        return false;
    }
}
