<?php
	require_once 'include/PolynomialRegression/PolynomialRegression.php';
	$data = array
    (
		array( 0.00, 0.65646507 ), array( 0.05, 0.61435503 ),
		array( 0.10, 0.63151965 ), array( 0.15, 0.57711365 ),
		array( 0.20, 0.58534249 ), array( 0.25, 0.54148715 ),
		array( 0.30, 0.43877649 ), array( 0.35, 0.39516968 ),
		array( 0.40, 0.24977940 ), array( 0.45, 0.24246690 ),
		array( 0.50, 0.07730788 ), array( 0.55, 0.03633931 ),
		array( 0.60, 0.08980716 ), array( 0.65, 0.07562991 ),
		array( 0.70, 0.11196788 ), array( 0.75, 0.15086596 ),
		array( 0.80, 0.19979455 ), array( 0.85, 0.34683801 ),
		array( 0.90, 0.48338650 ), array( 0.95, 0.59196113 ),
		array( 1.00, 0.99233320 )
	);

  // Precision digits in BC math.
  bcscale( 10 );

  // Start a regression class with a maximum of 4rd degree polynomial.
  $polynomialRegression = new PolynomialRegression( 6 );

  // Add all the data to the regression analysis.
  foreach ( $data as $dataPoint )
    $polynomialRegression->addData( $dataPoint[ 0 ], $dataPoint[ 1 ] );

  $Y_MajorScale   = 0.1;
  $Y_MinorScale   = $Y_MajorScale / 5;
  $X_MajorScale   = 0.1;
  $X_MinorScale   = $X_MajorScale / 5;

  // Get coefficients for the polynomial.
  $coefficients = $polynomialRegression->getCoefficients();

  $functionText = "f( x ) = ";
  foreach ( $coefficients as $power => $coefficient )
  {
    if ( $power > 0 )
      $functionText .= " + ";

    $functionText .= round( $coefficient, 10 );

    if ( $power > 0 )
    {
      $functionText .= "x";
      if ( $power > 1 )
        $functionText .= "^" . $power;
    }
  }

  echo $functionText;
?> 