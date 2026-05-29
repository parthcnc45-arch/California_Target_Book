// Vue filters

Vue.filter('currency', function (value) {
    if (!value) return 0;
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});


Vue.filter('stripeCost', function (v) {
    if (!v) return 0;
    return (v/100).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

Vue.filter('address', function (v) {
    if (!v) return '';
    let addr = v.line1 + '<br />';
    if (v.line2) addr += v.line2 + '<br />';
    addr += `${v.city}, ${v.state} ${v.zip_code}`;
    if (v.special_instructions) addr += `<br/><i>${v.special_instructions}</i>`;

    return addr;
});