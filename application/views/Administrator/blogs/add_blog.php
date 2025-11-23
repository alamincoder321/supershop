<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select.open .dropdown-toggle {
		border-bottom: 1px solid #ccc;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#blogs label {
		font-size: 13px;
	}

	#blogs select {
		border-radius: 3px;
	}

	#blogs .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#blogs .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#blogs input[type="file"] {
		display: none;
	}

	#blogs .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#blogs .custom-file-upload:hover {
		background-color: #41add6;
	}

	#customerImage {
		height: 100%;
	}

	tr td {
		vertical-align: middle !important;
	}

	.modal-header .close {
		position: absolute;
		top: 0;
		right: 15px;
	}

	.blog_img_remove {
		position: absolute;
		width: 10px;
		height: 20px;
		padding: 5px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 5px;
		top: 7px;
		right: 7px;
	}
</style>
<div id="blogs">
	<form @submit.prevent="saveblog">
		<div class="row"
			style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
			<div class="col-md-9">

				<div class="form-group clearfix">
					<label class="control-label col-md-4">blog Title:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="blog.title" required>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">blog Status:</label>
					<div class="col-md-7">
						<select class="form-control" v-model="blog.status" required>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-3">

				<div class="">
					<div class="form-group clearfix">
						<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
							<img id="customerImage" v-if="imageUrl == '' || imageUrl == null"
								src="/assets/no_image.gif">
							<img id="customerImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
						</div>
						<div style="text-align:center;">
							<label class="custom-file-upload">
								<input type="file" @change="previewImage" />
								Select Image
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">

				<div class="form-group clearfix">
					<label class="control-label col-md-3">blog Short Description:</label>
					<div class="col-md-8">
						<textarea class="form-control" v-model="blog.short_description" required></textarea>
					</div>
				</div>


				<div class="form-group clearfix">
					<label class="control-label col-md-3">blog Description:</label>
					<div class="col-md-8">
						<textarea ref="summernote" class="form-control editor_summernote" v-model="blog.description"
							required></textarea>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-11 text-right">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>
			</div>


		</div>
	</form>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="blogs" :filter-by="filter">
					<template scope="{ row }">
						<tr>
							<td>{{ row.sl }}</td>
							<td>
								<a :href="row.upload_idrc">
									<img :src="row.upload_idrc"
										style="width: 45px; height: 45px; border: 1px solid gray; border-radius: 5px; padding: 1px;" />
								</a>
							</td>

							<td style="text-align: left">{{ row.title }}</td>

							<td>{{ row.status }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>

									<button type="button" class="button edit" @click="editBlog(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteBlog(row.id)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
								
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>
		</div>
	</div>


	<!-- Button trigger modal -->





</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#blogs',
		data() {
			return {
				blog: {
					id: '',
					title: '',
					description: '',
					short_description: '',
					status: '',
					upload_id: '',
				},
				imageUrl: '',
				selectedFile: null,
				blogs: [],
				columns: [{
					label: 'Sl',
					field: 'sl',
					align: 'center'
				},
				{
					label: 'Image',
					field: 'upload_idrc',
					align: 'center'
				},

				{
					label: 'blog Name',
					field: 'title',
					align: 'center'
				},


				{
					label: 'Status ',
					field: 'status',
					align: 'center'
				},
				{
					label: 'Action',
					align: 'center',
					filterable: false
				}
				],
				page: 1,
				per_page: 10,
				filter: ''
			}
		},
		created() {
			this.getBlogs();
			setTimeout(() => {
				$(this.$refs.summernote).summernote({
					height: 200,
					placeholder: 'Write something...',
					callbacks: {
						onChange: (contents) => {
							this.currentContent = contents; // Keep Vue data reactive
						}
					}
				});

			}, 1000);
		},
		methods: {



			getBlogs() {
				axios.get('/get_blogs').then(res => {
					this.blogs = res.data.map((item, index) => {
						item.upload_idrc = item.upload_id ? `/uploads/blogs/${item.upload_id}` : '/uploads/noImage.png';
						item.sl = index + 1;
						return item;
					});
				})
			},

			saveblog() {
			
				let fd = new FormData();
				fd.append('image', this.selectedFile);
				this.blog.description = $(this.$refs.summernote).summernote('code');
				fd.append('data', JSON.stringify(this.blog));

				let url = '/add_blog';
				if (this.blog.id != 0) {
					url = '/update_blog';
				}
				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
					}
				})
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							$(this.$refs.summernote).summernote('code', '');
							this.clearForm();
							this.getBlogs();
						}
					})

			},
			editBlog(blog) {
				let keys = Object.keys(this.blog);
				keys.forEach(key => {
					this.blog[key] = blog[key];
				})
				if (blog.upload_id) {
					this.blog.upload_id = blog.upload_id;
				} else {
					this.blog.upload_id = '';
				}
				$(this.$refs.summernote).summernote('code', blog.description);


				if (blog.upload_id == null || blog.upload_id == '') {
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/blogs/' + blog.upload_id;
				}
			},
			deleteBlog(blogId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_blog', {
					blogId: blogId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getBlogs();
					}
				})
			},
			clearForm() {
				let keys = Object.keys(this.blog);
				keys.forEach(key => {
					if (typeof (this.blog[key]) == "string") {
						this.blog[key] = '';
					} else if (typeof (this.blog[key]) == "number") {
						this.blog[key] = 0;
					}
				})

				this.imageUrl = '';
				this.selectedFile = null;
			

			},
			previewImage(event) {
				const WIDTH = 200;
				const HEIGHT = 200;
				if (event.target.files[0]) {
					let reader = new FileReader();
					reader.readAsDataURL(event.target.files[0]);
					reader.onload = (ev) => {
						let img = new Image();
						img.src = ev.target.result;
						img.onload = async e => {
							let canvas = document.createElement('canvas');
							canvas.width = WIDTH;
							canvas.height = HEIGHT;
							const context = canvas.getContext("2d");
							context.drawImage(img, 0, 0, canvas.width, canvas.height);
							let new_img_url = context.canvas.toDataURL(event.target.files[0].type);
							this.imageUrl = new_img_url;
							const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1))
							this.selectedFile = new File([resizedImage], event.target.files[0].name, {
								type: resizedImage.type
							});
						}
					}
				} else {
					event.target.value = '';
				}
			},
		}
	})
</script>