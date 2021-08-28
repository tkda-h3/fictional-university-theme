import $ from 'jquery';

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $('#my-notes').on('click', '.delete-note', this.deleteNote); // 新規作成したノートにもeventListenerを追加できる
    $('#my-notes').on('click', '.edit-note', this.editNote.bind(this));
    $('#my-notes').on('click', '.update-note', this.updateNote.bind(this));
    $('.submit-note').on('click', this.createNote.bind(this));
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
    if (thisNote.data('state') == 'editable') {
      this.makeNoteReadOnly(thisNote);
    } else {
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

  updateNote(e) {
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

  createNote(e) {
    let thisNote = $('.create-note');

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/wp/v2/note/', // 複数形
      type: 'POST',
      data: {
        'title': thisNote.find('.new-note-title').val(),
        'content': thisNote.find('.new-note-body').val(),
        'status': 'publish',
      },
      success: (response) => {
        console.log(response);
        $('.new-note-title, .new-note-body').val('');
        $(`
        <li data-id="${response.id}" data-state='cancel'>
          <input readonly type="text" value="${response.title.raw}" class="note-title-field">
          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> 編集</span>
          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> 削除</span>
          <textarea readonly name="" id="" cols="30" rows="10" class="note-body-field">${response.content.raw}</textarea>

          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> 保存</span>
        </li>
        `).prependTo('#my-notes').hide().slideDown()

        console.log('Congrats 作成');
      },
      error: (response) => {
        console.log('Sorry 作成');
        console.log(response);
      },
    });
  }
}

export default MyNotes;
