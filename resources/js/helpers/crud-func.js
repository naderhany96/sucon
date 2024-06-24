export const fetchComponentData = async function(){
    let that = this;
    await that.axios.get(that.fetchLink).then(function(response){
        that.componentData = response.data;
        that.isBusy = false;
    })
}

export const dynamicFetchComponentData = async function(){
    let that = this;
    that.isBusy = true;
    let url = `${that.fetchLink}?page=${that.currentPage}&limit=${that.perPage}&search=${that.search}`;
    await that.axios.get(url).then(function(response){
        // console.log(response);
        that.componentData = response.data.data;
        that.totalRows = response.data.total;
        that.isBusy = false;
    })
    .catch(error => {
        console.error(error)
        that.isBusy = false;
    })
}

export const viewItem = function(item, button, routeName) {
    button.disabled = true;
    this.$router.push({name: routeName, params: { id: item.id }})
}

export const editItem = function(item, button, routeName) {
    button.disabled = true;
    this.$router.push({name: routeName, params: { id: item.id }})
}

export const deleteItem = async function(item, button, deleteLink) {
    let that = this;
    button.disabled = true;
    await that.axios.post( deleteLink + item.id ).then(function(){
        that.fetchComponentData();
        button.disabled = false;
        that.$iziToast.success({message: 'Deleted Succesfully', position: 'bottomCenter', timeout: 3000});
    })
    .catch(function(error){
      button.disabled = false;
      if (error.response) {
        if (error.response.status == 422) {
            let error_msg = error.response.data.message;
            that.$iziToast.warning({message: error_msg, position: 'bottomCenter', timeout: 8000});
        } else {
            that.$iziToast.error({message: 'Not deleted', position: 'bottomCenter', timeout: 3000});
        }
      }
    });
}

export const dynamicDeleteItem = async function(item, button, deleteLink) {
    let that = this;
    button.disabled = true;
    await that.axios.post( deleteLink + item.id ).then(function(){
        that.dynamicFetchComponentData();
        button.disabled = false;
        that.$iziToast.success({message: 'Deleted Succesfully', position: 'bottomCenter', timeout: 3000});
    })
    .catch(function(error){
      button.disabled = false;
      if (error.response) {
        if (error.response.status == 422) {
            let error_msg = error.response.data.message;
            that.$iziToast.warning({message: error_msg, position: 'bottomCenter', timeout: 8000});
        } else {
            that.$iziToast.error({message: 'Not deleted', position: 'bottomCenter', timeout: 3000});
        }
      }
    });
}

export const deleteFile = function(item, index, button) {
    let that = this;
    button.disabled = true;
    let formData = new FormData();
    formData.append('backup_file_path', item.path);
    formData.append('filename', item.filename);

    that.axios.post( that.deleteLink, formData ).then(function(){
      button.disabled = false;
      that.fetchComponentData();
      that.$iziToast.success({message: 'Deleted Succesfully', position: 'bottomCenter'});
    })
    .catch(function(error){
      button.disabled = false;
      if (error.response) {
        that.$toast.error('Not deleted');
      }
    });
}

export const askBeforDelete = function(item, index, button){
    let that = this;
    that.$swal.fire({
        title: 'Confirm Delete',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#34c38f',
        confirmButtonColor: '#f46a6a',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            that.deleteItem(item, index, button);
        }
    })
}

export const askBeforDeleteFile = function(item, index, button){
    let that = this;
    that.$swal.fire({
        title: 'Confirm Delete',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#34c38f',
        confirmButtonColor: '#f46a6a',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            that.deleteFile(item, index, button);
        }
    })
}

// search in table
export const onFiltered = function(filteredItems) {
    // Trigger pagination to update the number of buttons/pages due to filtering
    this.totalRows = filteredItems.length;
    this.currentPage = 1;
}


export const focusRef = function(ref) {
    this.$nextTick(() => {
        this.$nextTick(() => {
            (ref.$el || ref).focus()
        })
    })
}