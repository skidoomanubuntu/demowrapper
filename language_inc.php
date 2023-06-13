<script>
var table = [
	['OS','オペレイティングシステム'],
	['Kernel', 'カーネル'],
	['Chipset', 'チップセット'],
        ['Name', '名前'],
	['IP', 'チップセット'],
	['Welcome to Canonical', 'カノニカルへようこそ'],
	['Home', 'ホーム'],
	['Sensors', 'センサー'],
	['Update', 'アップデート'],
	['Auto', '自動車'],
	['Captions', 'キャプション'],
	['Logo', 'ロゴ'],
	['Rotate', '回転'],
        ['Real-time', 'リアルタイム'],
        ['Core Car', 'コアカー']
];
function lookup_translation(myString, col)
{
	for(var i=0; i<table.length; i++)
	{
		if (table[i].length > col && table[i][0] == myString)
			return table[i][col];
	}
	return myString;
}

function translate_direct(myString)
{
	//var jp = <?echo 'true'?>;
	var jp = <? if (file_exists('jp')) echo 'true'; else echo 'false';?>;
	if (jp) return lookup_translation(myString, 1); 
	return myString;
}

function translate(myString)
{
	return document.write(translate_direct(myString));
}
</script>
