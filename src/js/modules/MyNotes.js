import $ from 'jquery';

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $('.delete-note').on('click', this.deleteNote);
    $('.edit-note').on('click', this.editNote.bind(this));
    $('.update-note').on('click', this.updateNote.bind(this));
  }

  deleteNote(e) {
    let thisNote = $(e.target).parents('li');

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce); // リクエストヘッダーに once を渡して認可
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'DELETE',
      success: (response) => {
        thisNote.slideUp();
        console.log('Congrats');
        console.log(response);
      },
      error: (response) => {
        console.log('Sorry');
        console.log(response);
      },
    });
  }

  editNote(e) {
    let thisNote = $(e.target).parents('li');
    if(thisNote.data('state') == 'editable') {
      this.makeNoteReadOnly(thisNote);
    }else{
      this.makeNoteEditable(thisNote);
    }
  }

  makeNoteEditable(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> キャンセル')
    thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field")
    thisNote.find(".update-note").addClass("update-note--visible")
    thisNote.data("state", "editable")
  }

  makeNoteReadOnly(thisNote) {
    thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> 編集')
    thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field")
    thisNote.find(".update-note").removeClass("update-note--visible")
    thisNote.data("state", "cancel")
  }

  updateNote(e){
    let thisNote = $(e.target).parents('li');
    const id = thisNote.data('id');

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
      type: 'POST',
      data: {
        'title': thisNote.find('.note-title-field').val(),
        'content': thisNote.find('.note-body-field').val(),
      },
      success: (response) => {
        this.makeNoteReadOnly(thisNote);
        console.log('Congrats update');
        console.log(response);
      },
      error: (response) => {
        console.log('Sorry update');
        console.log(response);
      },
    });
  }
}

export default MyNotes;
