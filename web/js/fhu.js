$(document).ready(() => {
  addNewUploadElement();
  $.ajax('./stats.json', { dataType: 'json', success: function(data) {
    $("#stats").text(data.count + " replays uploaded taking up " + humanFileSize(data.size)
        + ` (last updated ${formatTimeDifference(data.time)} minutes ago)`);
  }});
});

function addNewUploadElement() {
  $(`#noJsBanner`).remove();

  let newUploadElement = $(`#template .uploadElement`).clone();

  newUploadElement.find(`input`).on(`change`, onFileSelectedHandler);
  newUploadElement.find(`button`).on(`click`, () => newUploadElement.remove());

  newUploadElement.appendTo(`#content`);
}

function onFileSelectedHandler() {
  var ext = $(this).val().split('.').pop().toLowerCase();

  if (ext !== `hbr2`) {
    updateStatus(this, `Error: Invalid file extension, please select .hbr2 file`);
    return false;
  }

  if (this.files[0].size > 300000) {
    updateStatus(this, `Error: File size exceeds upload limit of 300kb`);
    return false;
  }

  updateStatus(this, `Valid file selected, uploading...`);

  let formData = new FormData();
  formData.append(`file`, this.files[0]);

  $.ajax({
    url: `./upload.php`,
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    dataType: `json`,
    type: `POST`,
    context: this,
    success: handleUploadResponse,
  });

  return true;
}

function handleUploadResponse(data, textStatus, jqXHR) {
  if (data[`status`] === 0) {
    updateStatus(this, `Error: ${data.message}`);
  } else {
    updateStatus(this, `Upload complete`);
    showLinks(this, data.message);
  }
}

function updateStatus(forInput, text) {
  $(forInput).parent().siblings(`span.status`).text(text);
}

function showLinks(forInput, url) {
  let uploadElement = $(forInput).parents(`.uploadElement`);

  uploadElement.find(`input[name=watch]`).val(url);
  uploadElement.find(`a.watch`).attr(`href`, url);
  uploadElement.find(`input[name=download]`).val(url + `.hbr2`);
  uploadElement.find(`a.download`).attr(`href`, url + `.hbr2`);
  uploadElement.find(`button`).on(`click`, copyLink);
  uploadElement.find(`.links`).removeClass(`hidden`);
}

function copyLink() {
  var copyText = $(this).siblings(`input`)[0];

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand(`copy`);

  $("button.copy").text(`Copy link`);
  $(this).text(`Copied!`);
}

function humanFileSize(bytes, si) {
  bytes *= 1000;
  var thresh = si ? 1000 : 1024;
  if(Math.abs(bytes) < thresh) {
    return bytes + ' B';
  }
  var units = si
    ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
    : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
  var u = -1;
  do {
    bytes /= thresh;
    ++u;
  } while(Math.abs(bytes) >= thresh && u < units.length - 1);
  return bytes.toFixed(1)+' '+units[u];
}

function formatTimeDifference(timestamp) {
  return Math.round((Date.now()-timestamp*1000)/60000);
}
