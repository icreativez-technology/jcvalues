function createPagination(totalPages, page) {
	let liTag = '';
	let active;
	let beforePage = page - 2;
	let afterPage = page + 2;
	let prevLabel = "<";
	let nextLabel = ">";
	let firstPage = "<<";
	let lastPage = ">>";
	liTag +=
		`<li class="page-item m-1"><a href="/admin_user-panel.php?page=${1}" class="page-link">${firstPage}</a></li>`;
	if (page > 1) {
		liTag +=
			`<li class="page-item m-1"><a href="/admin_user-panel.php?page=${page - 1}" class="page-link">${prevLabel}</a></li>`;
	}
	if (page == totalPages) {
		beforePage = beforePage - 2;
	} else if (page == totalPages - 1) {
		beforePage = beforePage - 1;
	}
	if (page == 1) {
		afterPage = afterPage + 2;
	} else if (page == 2) {
		afterPage = afterPage + 1;
	}
	beforePage = beforePage > 0 ? beforePage : 1;
	for (var plength = beforePage; plength <= afterPage; plength++) {
		if (plength > totalPages) {
			continue;
		}
		if (plength == 0) {
			plength = plength + 1;
		}
		if (page == plength) {
			active = "active";
		} else {
			active = "";
		}
		liTag +=
			`<li class="page-item m-1 ${active}"><a href="/admin_user-panel.php?page=${plength}" class="page-link">${plength}</a></li>`;
	}
	if (page < totalPages) {
		liTag +=
			`<li class="page-item m-1"><a href="/admin_user-panel.php?page=${page + 1}" class="page-link">${nextLabel}</a></li>`;
	}
	liTag +=
		`<li class="page-item m-1"><a href="/admin_user-panel.php?page=${totalPages}" class="page-link">${lastPage}</a></li>`;
	element.innerHTML = liTag;
	return liTag;
}