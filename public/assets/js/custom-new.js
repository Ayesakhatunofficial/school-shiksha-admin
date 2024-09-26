
function secondsToTime(e) {
  m = Math.floor(e % 3600 / 60).toString().padStart(2, '0'),
    s = Math.floor(e % 60).toString().padStart(2, '0');

  return m + ':' + s;
}

function Timer(domNode, totalSeconds) {
  domNode.innerHTML = secondsToTime(totalSeconds);
}


function GenerateQR(text_qr) {

  var sampleQR = new QRCode('qrcode', {
    text: text_qr,
    width: 228,
    height: 228,
    colorDark: '#000000',
    colorLight: '#ffffff',
    correctLevel: QRCode.CorrectLevel.H
  })

  updateQR = (text_qr) => {
    sampleQR.makeCode(text_qr)
  }
}

