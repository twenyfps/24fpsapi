<?php
header("Content-type: application/json; charset=utf-8");
$result = '{
	"status": "ok",
    "status_message": "Query was successful",
    "data" : {
	"mobile":{
		"version":"",
		"link":""
		},

	"tv":{
		"version":"",
		"link":""
		},

	"tablet":{
		"version":"",
		"link":""
		}
	},
	"genres":"action;adventure;animation;biography;comedy;crime;documentary;drama;family;fantasy;history;horror;musical;mystery;news;romance;sci-fi;sport;thriller;war;western"
}';
echo $result;
?>