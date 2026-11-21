function formatINR(number) {
    return '₹' + Math.round(number).toLocaleString('en-IN');
}
function formatKm(km) {
    return Math.round(km).toLocaleString('en-IN') + ' km';
}
function calculateUrbaniaFare({ oneWayKm, days, ratePerKm }) {
    const roundTripKm = Math.round(oneWayKm * 2);
    const chargeableDistanceKm = Math.round(250 * days);
    const billableKm = Math.max(roundTripKm, chargeableDistanceKm);
    const totalFare = Math.round(billableKm * ratePerKm);
    return {
        oneWayKm,
        roundTripKm,
        days,
        chargeableDistanceKm,
        billableKm,
        ratePerKm,
        totalFare,
        formattedPrice: formatINR(totalFare)
    };
}

// Simulated UI update test
function simulateCardUI(oneWayKm, days, ratePerKm) {
    const calc = calculateUrbaniaFare({ oneWayKm, days, ratePerKm });
    const roundTripText = formatKm(calc.roundTripKm);
    const chargeableLabel = 'Chargeable Distance:';
    const chargeableText = formatKm(calc.billableKm); // Bound to billableKm
    const totalFareText = calc.formattedPrice;
    return {
        roundTripText,
        chargeableLabel,
        chargeableText,
        totalFareText,
        totalFareRaw: calc.totalFare
    };
}

console.log("=== TESTING USER EXAMPLES (Round trip: 790 km, ₹45/km) ===");
const tests = [
    { days: 1, expRound: '790 km', expChargeable: '790 km', expFare: '₹35,550' },
    { days: 3, expRound: '790 km', expChargeable: '790 km', expFare: '₹35,550' },
    { days: 4, expRound: '790 km', expChargeable: '1,000 km', expFare: '₹45,000' },
    { days: 10, expRound: '790 km', expChargeable: '2,500 km', expFare: '₹1,12,500' }
];

let allPass = true;
tests.forEach(t => {
    const ui = simulateCardUI(395, t.days, 45);
    const passLabel = ui.chargeableLabel === 'Chargeable Distance:';
    const passDist = ui.chargeableText === t.expChargeable;
    const passFare = ui.totalFareText === t.expFare;
    const pass = passLabel && passDist && passFare;
    if (!pass) allPass = false;
    console.log(`Day ${t.days}:`);
    console.log(`  Label: "${ui.chargeableLabel}" [${passLabel ? 'PASS' : 'FAIL'}]`);
    console.log(`  Round Trip: ${ui.roundTripText}`);
    console.log(`  Chargeable Distance: ${ui.chargeableText} (expected ${t.expChargeable}) [${passDist ? 'PASS' : 'FAIL'}]`);
    console.log(`  Total Fare: ${ui.totalFareText} (expected ${t.expFare}) [${passFare ? 'PASS' : 'FAIL'}]`);
});

if (allPass) {
    console.log("\nALL DISPLAY-ONLY TESTS PASSED 100%!");
} else {
    console.log("\nTESTS FAILED!");
    process.exit(1);
}
