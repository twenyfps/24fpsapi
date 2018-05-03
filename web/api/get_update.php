<?php
header("Content-type: application/json; charset=utf-8");
$result = '{
	"status": "ok",
    "status_message": "Query was successful",
    "data" : {
	"mobile":{
		"version":"1.0.2",
		"link":""
		},

	"tv":{
		"version":"1.0.2",
		"link":""
		},

	"tablet":{
		"version":"1.0.2",
		"link":""
		},
	"genres":"action;adventure;animation;biography;comedy;crime;documentary;drama;family;fantasy;history;horror;musical;mystery;news;romance;sci-fi;sport;thriller;war;western"
	}
}';
echo $result;
?>