function getKeyBoard($objs){
	$nums='1 2 3 4 5 6 7 8 9 0';
	$chars='a b c d e f g h i j k l m n o p q r s t u v w x y z';
	$randNums=getTheArrayItems($nums.split(" ")).join(" ");
	//$randChars=getTheArrayItems($chars.split(" ")).join(" ");
	$randChars=$chars;
	$chars1=$randChars.substr(0,25);
	$chars2=$randChars.substr(25,26);
	$objs.keyboard({
		layout:'custom',
		customLayout:{
			'default':[
			$randNums,
			$chars1,
			$chars2,
			'{shift} {accept} {cancel} {bksp}'
			],
			'shift':[
			$randNums,
			$chars1.toUpperCase(), 
			$chars2.toUpperCase(), 
			'{shift} {accept} {cancel} {bksp}'
			]
		},
		display:{
			'shift':'大小写',
			'accept':'确定',
			'cancel':'取消',
			'bksp':'后退',
		},
		lockInput : true,
		restrictInput : true,
		useCombos : true,
		accepted : function(e, keyboard, el){}
	});
};

function getNumKeyBoard($objs){
	$nums='1 2 3 4 5 6 7 8 9 0';
	$randNums=getTheArrayItems($nums.split(" ")).join(" ");
	$objs.keyboard({
		layout:'custom',
		customLayout:{
			'default':[
			$randNums,
			'{accept} {cancel} {bksp}'
			],
			'shift':[
			$randNums,
			'{accept} {cancel} {bksp}'
			]
		},
		display:{
			'accept':'确定',
			'cancel':'取消',
			'bksp':'后退',
		},
		lockInput : true,
		restrictInput : true,
		useCombos : true,
		accepted : function(e, keyboard, el){}
	});
};
function getTheArrayItems(arr) {
	var temp_array = new Array();
	var num=arr.length;
	for (var index in arr) {
		temp_array.push(arr[index]);
	}
	var return_array = new Array();
	for (var i = 0; i<num; i++) {
		if (temp_array.length>0) {
			var arrIndex = Math.floor(Math.random()*temp_array.length);
			return_array[i] = temp_array[arrIndex];
			temp_array.splice(arrIndex, 1);
		} else {
			break;
		}
	}
	return return_array;
}
