ConfirmCheck = (_txt) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        console.log(result)
        if (result.isConfirmed) {
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
       
        } else {
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'error'
              )        
        }
              return(true)
    })
}

answerIncorrect = (_text , _textDetail) => {
  Swal.fire(
    _text,
    _textDetail,
    'warning'
  )  
}