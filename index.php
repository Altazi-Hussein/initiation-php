<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/calendar.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
	<nav class="navbar navbar-dark bg-primary mb-3">
		<a href="index.php" class="navbar-brand">Calendrier</a>
	</nav>

<?php 
require 'src/Date/Month.php';
if (isset($_GET['month']))
{
	$mois = $_GET['month'];
}
if(isset($_GET['year']))
{
	$annee = $_GET['year'];
}
try
{
$month = new src\Date\Month($mois ?? null, $annee ?? null); 
$start = $month->getStartingDay() ->modify('last monday');
} catch(Exception $e)
{
	$month = new src\Date\Month();
}
?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
	<h1><?php echo $month->toString(); ?></h1>
	<div>
		<a href="index.php?month=<?= $month->previousMonth()->month ?>&year=<?= $month->previousMonth()->year ?>" class="btn btn-primary">&lt;</a>
		<a href="index.php?month=<?= $month->nextMonth()->month ?>&year=<?= $month->nextMonth()->year ?>" class="btn btn-primary">&gt;</a>
	</div>
</div>




<table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
	<?php for($i = 0;$i<$month->getWeeks();$i++): ?>
	<tr>
		<?php foreach ($month->days as $k => $day): 
			$date = (clone $start)->modify("+" . ($k + $i  * 7) . "days");
			?>
			<td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
				<?php if($i===0): ?>
			<div class="calendar__weekday"><?= $day; ?></div>
		<?php endif;?>
			<div class="calendar__day"><?= $date->format('d'); ?></div>
			</td>

			<?php endforeach; ?>
	</tr>
		
	<?php endfor; ?>

</table>
</body>
</html>