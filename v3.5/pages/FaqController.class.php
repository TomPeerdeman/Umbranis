<?php	//Dit bestand kan alleen vanuit de index aangeroepen worden	if(!defined("INDEX"))die("NO INDEX!");		class FaqController extends BaseController{		public function buildPage(){?><div id="contentcontainer">	<h2>FAQ</h2>	<div id="faqbox">		<br />		Hier worden de belangrijkste vragen beantwoordt aangaande deze website.<br /><br />		<i><b>Hoe werkt de winkelwagen?</i></b><br />		Op iedere productpagina bevind zich een knop waarmee u het desbetreffende product in uw persoonlijke		winkelwagen kunt stoppen. Zodra u hierop klikt word het product onthouden door ons systeem en kunt u		doorwinkelen. Bent u klaar met winkelen en wilt u afrekenen dan gaat u naar uw winkelwagen toe door op		de winkelwagen link te drukken rechtsboven op de pagina. Alle toegevoegde producten bevinden zich dan in		uw winkelwagen. Wilt u nog wat aanpassen dan is daar nog een mogelijkheid toe. U kunt nog producten		verwijderen, of de hoeveelheden aanpassen.<br /><br />		<i><b>Is er een mogelijkheid mijn product te ruilen?</i></b><br />		Ruilen is helaas niet mogelijk. Er is echter wel een mogelijkheid om het product te laten retourneren		als deze beschadigd bij u wordt afgeleverd of als het product niet werkt.<br />		<b>Let op!:</b> Dit moet u kunnen aantonen, controleer het product bij aflevering dus direct op schade.		<br /><br />		<i><b>Ik ben mijn wachtwoord vergeten, wat nu?</i></b><br />		Bent u uw wachtwoord vergeten dan kunnen wij u een tijdelijk wachtwoord opsturen naar uw opgegeven mailadres.		<br /><br />		<i><b>Ik heb een vraag en deze is hier niet beantwoord, wat moet ik doen?</i></b><br />		Stuur uw vraag naar ons mailadres. Deze is te vinden op onze contactpagina.<br />		&nbsp;	</div></div><?php		}	}?>