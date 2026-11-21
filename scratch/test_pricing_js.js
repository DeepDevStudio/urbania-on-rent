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

const expectedFares = {
    1: 59400,
    2: 59400,
    3: 59400,
    4: 59400,
    5: 59400,
    6: 67500,
    7: 78750,
    8: 90000,
    9: 101250,
    10: 112500
};

let allPass = true;
console.log("=== JS CLIENT-SIDE FARE CALCULATION TEST (660 km one-way @ ₹45/km) ===");
for (let d = 1; d <= 10; d++) {
    const res = calculateUrbaniaFare({ oneWayKm: 660, days: d, ratePerKm: 45 });
    const dayWord = d === 1 ? 'Day' : 'Days';
    const label = `Chargeable Distance (250 × ${d} ${dayWord}):`;
    const exp = expectedFares[d];
    const pass = (res.totalFare === exp);
    if (!pass) allPass = false;
    console.log(`Day ${d} | RoundTrip: ${formatKm(res.roundTripKm)} | ${label} ${formatKm(res.chargeableDistanceKm)} | Billable: ${formatKm(res.billableKm)} | Total: ${res.formattedPrice} | [${pass ? 'PASS' : 'FAIL'}]`);
}

if (allPass) {
    console.log("ALL JS FARE CALCULATIONS PASSED 100%!");
} else {
    console.log("JS TESTS FAILED!");
    process.exit(1);
}
