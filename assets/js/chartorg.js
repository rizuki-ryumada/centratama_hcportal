var nodes = [
	{
		id: "1",
		title: "Masukkan Jabatan Atasan Anda",
		me: ""
	},
	{
		id: "2",
		pid: "1",
		title: "Masukkan Jabatan",
		me: ""
	},
	{
		id: "3",
		pid: "1",
		title: "Masukkan Jabatan",
		me: ""
	},
	{
		id: "4",
		pid: "1",
		title: "Masukkan Jabatan",
		me: ""
	},
	{
		id: "5",
		pid: "2",
		title: "Masukkan Jabatan",
		me: "My Position"
	}
];
for (var i = 0; i < nodes.length; i++) {
	var node = nodes[i];
	if (node.me < 1) {
		node.tags = [];
	} else {
		node.tags = ["me"];
	}
}

var chart = new OrgChart(document.getElementById("tree"), {
	template: "ana",
	mouseScrool: OrgChart.action.none,
	enableDragDrop: true,
	enableSearch: false,
	menu: {
		pdf: {
			text: "Export PDF"
		}
	},
	nodeMenu: {
		edit: {
			text: "Edit"
		},
		add: {
			text: "Add"
		},
		remove: {
			text: "Remove"
		}
	},
	nodeBinding: {
		field_0: "title",
		field_1: "me"
	},
	nodes: nodes
});
