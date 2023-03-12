<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admissibility of Extraordinary Appeal</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="tricolour" id="white"></div>
    <div class="tricolour" id="red"></div>
    <div class="tricolour" id="blue"></div>
    <h1>Can you file an extraordinary appeal against your court decision?</h1>
    <h2>According to the Czech Civil Procedure Code (Act No. 99/1963 Sb.)</h2>
    <form id="extraAppealForm" method="post" action="result.php">
        <table>
            <tr>
                <td class="leftc">Was the court acting as an appellate court?</td>
                <td>
                    <input name="appellateCourt" id="appellateCourt1" type="radio" value="y" />
                    <label for="appellateCourt1">Yes</label>
                    <input name="appellateCourt" id="appellateCourt0" type="radio" value="n" />
                    <label for="appellateCourt0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Is the decision final?</td>
                <td>
                    <input name="decisionFinal" id="decisionFinal1" type="radio" value="y" />
                    <label for="decisionFinal1">Yes</label>
                    <input name="decisionFinal" id="decisionFinal0" type="radio" value="n" />
                    <label for="decisionFinal0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Did the decision end the appellate court’s proceedings?</td>
                <td>
                    <input name="endedProceedings" id="endedProceedings1" type="radio" value="y" />
                    <label for="endedProceedings1">Yes</label>
                    <input name="endedProceedings" id="endedProceedings0" type="radio" value="n" />
                    <label for="endedProceedings0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">How did the appellate court decide?</td>
                <td>
                    <input name="verdict" id="verdict1" type="radio" value="1" />
                    <label for="verdict1">It quashed the decision of the court of first instance and referred the case back to it.</label><br />
                    <input name="verdict" id="verdict2" type="radio" value="2" />
                    <label for="verdict2">It rejected to admit an appeal.</label><br />
                    <input name="verdict" id="verdict3" type="radio" value="3" />
                    <label for="verdict3">It halted the appellate proceedings.</label><br />
                    <input name="verdict" id="verdict4" type="radio" value="4" />
                    <label for="verdict4">It upheld or changed a resolution of a court of first instance by which the court rejected to admit an appeal or an extraordinary appeal on grounds of it being filed too late. </label><br />
                    <input name="verdict" id="verdict5" type="radio" value="5" />
                    <label for="verdict5">It decided in a different way.</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">When was the decision delivered to you?</td>
                <td>
                    <input name="decisionDeliveryDate" type="date" />
                </td>
            </tr>
            <tr>
                <td class="leftc">Was there a resolution that corrected the decision? <br /> If yes, when was it delivered to you?</td>
                <td>
                    <input name="correctingResolution" id="correctingResolution1" type="radio" value="y" />
                    <label for="correctingResolution1">
                        Yes, it was delivered on
                        <input name="correctingResolutionDeliveryDate" type="date" />
                    </label>
                    <input name="correctingResolution" id="correctingResolution0" type="radio" value="n" />
                    <label for="correctingResolution0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">What does the advice at the very end of the decision say?</td>
                <td>
                    <input name="advice" id="advice1" type="radio" value="1" />
                    <label for="advice1">It is possible to file an extraordinary appeal within 2 months after the delivery of the decision.</label><br />
                    <input name="advice" id="advice2" type="radio" value="2" />
                    <label for="advice2">
                        It is possible to file an extraordinary appeal within
                        <input name="advice2_1" type="number" min="1" placeholder="amount" />
                        <select name="advice2_2">
                            <option value="d">days</option>
                            <option value="w">weeks</option>
                            <option value="m" selected>months</option>
                            <option value="y">years</option>
                        </select>
                        after the delivery of the decision.
                    </label><br />
                    <input name="advice" id="advice3" type="radio" value="3" />
                    <label for="advice3">There is no advice on when an extraordinary appeal can be filed.</label><br />
                    <input name="advice" id="advice4" type="radio" value="4" />
                    <label for="advice4">According to the advice, extraordinary appeal is inadmissible.</label><br />
                    <input name="advice" id="advice5" type="radio" value="5" />
                    <label for="advice5">There is no advice at all.</label><br /><br />
                    <input name="adviceCourt" id="adviceCourt" type="checkbox" value="y" />
                    <label for="adviceCourt">Also, there is no advice on which court to file an extraordinary appeal with.</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Is an attorney going to represent you? <br /> If not, are you yourself a lawyer or will your corporation be represented by a lawyer?</td>
                <td>
                    <input name="representation" id="representation1" type="radio" value="y" />
                    <label for="representation1">Yes</label>
                    <input name="representation" id="representation0" type="radio" value="n" />
                    <label for="representation0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Does the decision directly concern money? <br /> If yes, how much?</td>
                <td>
                    <input name="money" id="money1" type="radio" value="y" />
                    <label for="money1">
                        Yes,
                        <input name="moneyAmount" type="number" min="0" placeholder="amount" />
                        CZK in total
                    </label>
                    <input name="money" id="money0" type="radio" value="n" />
                    <label for="money0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Does the decision directly concern any of these matters?</td>
                <td>
                    <input name="matter[]" id="matter1" type="checkbox" value="1" />
                    <label for="matter1">Money rooted in a consumer contract</label><br />
                    <input name="matter[]" id="matter2" type="checkbox" value="2" />
                    <label for="matter2">Money rooted in labour law</label><br />
                    <input name="matter[]" id="matter3" type="checkbox" value="3" />
                    <label for="matter3">Family law (except matrimonial property law)</label><br />
                    <input name="matter[]" id="matter4" type="checkbox" value="4" />
                    <label for="matter4">Registered partnership</label><br />
                    <input name="matter[]" id="matter5" type="checkbox" value="5" />
                    <label for="matter5">Postponement of execution of a court decision</label><br />
                    <input name="matter[]" id="matter6" type="checkbox" value="6" />
                    <label for="matter6">Preliminary measure or order measure</label><br />
                    <input name="matter[]" id="matter7" type="checkbox" value="7" />
                    <label for="matter7">Expert fees or interpreter fees</label><br />
                    <input name="matter[]" id="matter8" type="checkbox" value="8" />
                    <label for="matter8">Possessory protection (a resolution, not a judgment)</label><br />
                    <input name="matter[]" id="matter9" type="checkbox" value="9" />
                    <label for="matter9">Compensation for costs of proceedings</label><br />
                    <input name="matter[]" id="matter10" type="checkbox" value="10" />
                    <label for="matter10">Obligation to pay a court fee or exemption from court fees</label><br />
                    <input name="matter[]" id="matter11" type="checkbox" value="11" />
                    <label for="matter11">Designation of an attorney</label><br />
                </td>
            </tr>
            <tr>
                <td class="leftc">Does the decision directly concern any of these matters?</td>
                <td>
                    <input name="grounds[]" id="grounds1" type="checkbox" value="1" />
                    <label for="grounds1">Party’s procedural successor in the appellate proceedings</label><br />
                    <input name="grounds[]" id="grounds2" type="checkbox" value="2" />
                    <label for="grounds2">Passive substitution of a party during the appellate proceedings</label><br />
                    <input name="grounds[]" id="grounds3" type="checkbox" value="3" />
                    <label for="grounds3">Active substitution of a party during the appellate proceedings</label><br />
                    <input name="grounds[]" id="grounds4" type="checkbox" value="4" />
                    <label for="grounds4">Accession of a new party to the appellate proceedings</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Does the decision directly concern any other matter?</td>
                <td>
                    <input name="otherMatter" id="otherMatter1" type="radio" value="y" />
                    <label for="otherMatter1">Yes</label>
                    <input name="otherMatter" id="otherMatter0" type="radio" value="n" />
                    <label for="otherMatter0">No</label>
                </td>
            </tr>
            <tr>
                <td class="leftc">Why should the Supreme Court admit your extraordinary appeal?</td>
                <td>
                    <input name="grounds[]" id="grounds5" type="checkbox" value="5" />
                    <label for="grounds5">The appellate court got the facts wrong.</label><br />
                    <input name="grounds[]" id="grounds6" type="checkbox" value="6" />
                    <label for="grounds6">The appellate court deviated from the Supreme Court’s stable case law.</label><br />
                    <input name="grounds[]" id="grounds7" type="checkbox" value="7" />
                    <label for="grounds7">The Supreme Court has not yet dealt with this legal issue.</label><br />
                    <input name="grounds[]" id="grounds8" type="checkbox" value="8" />
                    <label for="grounds8">The Supreme Court’s case law regarding this legal issue is not stable.</label><br />
                    <input name="grounds[]" id="grounds9" type="checkbox" value="9" />
                    <label for="grounds9">The Supreme Court’s case law regarding this legal issue is stable but should be changed.</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="button" form="extraAppealForm">Evaluate</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>