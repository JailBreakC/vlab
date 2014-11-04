$ ->
    `
    var t = transfer();
    var parseDisc = function(data) {
        data = data[0];
        console.log(data);
        data = data['content'].split(0,200);
        $('#disc').html(data);
    }
    t.getText('vlab_disc', 'no', parseDisc);
    `