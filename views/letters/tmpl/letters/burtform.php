<?php defined('_JEXEC') or die('Restricted access');?>
<h5>Burt Rules</h5>
<p>
   <i>Please bring a completed form for each Burt camper.</i>
</p>
<p>
   I,
   <?php echo "$child->firstname $child->lastname";?>
   , agree to abide by the laws of the United States, of Missouri, of
   Washington County, of the City of Potosi, and by the rules of Trout
   Lodge, of MUUSA and of the Senior High program.
</p>
<p>I pledge I will:</p>
<ul>
   <li>not use, possesses, or be in the presence of illegal drugs.</li>
   <li>not use or possess alcohol.</li>
   <li>not engage in sex.</li>
   <li>not sexually harass another person.</li>
   <li>not be in the presence of alcohol except at Club Cratty, Coffee
      House, or with my parent/guardian.</li>
   <li>not possess fireworks or firearms.</li>
   <li>respect the Burt curfew of midnight.</li>
   <li>leave the Trout Lodge grounds only with a member of the Senior
      High Staff, and with signed permission of my parent, guardian or
      sponsor. I'll make sure my counselors know where I'm going to be.</li>
   <li>respect Trout Lodge's quiet hours of 10 PM to 8 AM.</li>
   <li>swim in designated areas only during designated times.</li>
   <li>respect the community and the individuals in it, including all
      youth and all counselors.</li>
   <li>respect MUUSA staff and Trout Lodge staff.</li>
   <li>obey all the other laws and rules that are not included in this
      list. If I'm not sure if something is allowed or not, I'll find
      out before doing it.</li>
</ul>
<p>I understand that if I break these rules, or break other laws or
   rules, I may be kicked out of the Burt program. If I am kicked out of
   the program, my parents or sponsor will be responsible for my
   housing.</p>
<p>Signed: ________________________________</p>
<p>
   Age:
   <?php echo $child->age;?>
   <br /> Grade Entering This Fall:
   <?php echo $child->grade;?>
   <br /> Address:
   <?php echo $letter->address1 . ($letter->address2 != "" ? " " . $letter->address2 : "") . " " . $letter->city . ", " . $letter->statecd . " " . $letter->zipcd;?>
   <br /> Email:
   <?php echo $child->email != "" ? $child->email : "________________________________";?>
</p>
<h5>Travel Release</h5>
<p>Parent/Guardian/Adult Sponsor, please initial one of the following:</p>
<p>The youth for whom I am responsible may leave MUUSA campus with a
   member of the MUUSA Senior High staff. The youth for whom I am
   responsible may leave MUUSA campus with specific approval from me
   each time the youth wishes to leave campus.</p>
<p>Initials: ________________________________</p>
<h5>Acknowledgement of Burt Rules</h5>
<p>I have read the Burt Rules and I understand that if the youth for
   whom I am responsible fails to uphold this contract and is barred
   from Burt, I will be responsible for their housing.</p>
<p>Signature: ________________________________</p>
<h5>Medical Consent and Information</h5>
<p>
   TO WHOM IT MAY CONCERN: I, ________________________________, make
   oath and say that I am the lawful guardian of
   <?php echo "$child->firstname $child->lastname"?>
   , born
   <?php echo $child->birthday?>
   . MUUSA's camp staff and, if applicable, the youth's adult sponsor*
   have my consent, in a case of medical need, to bring my youth to a
   medical professional who may administer any treatments that are
   considered necessary in his or her best judgment. This consent is
   given prior to any such medical treatment.
</p>
<p>If an injury or illness is life-threatening or in need of emergency
   treatment, I authorize MUUSA's camp staff or the youth's adult
   sponsor* to summon any and all professional emergency personnel to
   attend, transport, and treat the participant and to issue consent for
   any X-ray, anesthetic, blood transfusion, medication, or other
   medical diagnosis, treatment, or hospital care deemed advisable by,
   and to be rendered under the general supervision of any licensed
   physician, surgeon, dentist, hospital, or other medical professional
   or institution duly licensed to practice in the state in which such
   treatment is to occur. I further will not hold any persons liable for
   seeking or administering treatment acting on my behalf to the best of
   their judgment.</p>
<p>This consent is valid starting on Sunday, the first day of camp and
   expiring on Saturday, the final day of camp.</p>
<p>Signed: ________________________________</p>
<p>
   <i>*Adult sponsors are only applicable if parents/guardians will not
      be at camp.</i>
</p>
<h5>Medical Information</h5>
<p>
   Physician Name: ________________________________<br /> Physician
   Phone: ________________________________<br /> Physician Address:
   ________________________________<br /> Emergency Phone:
   ________________________________<br /> Health Insurance:
   ________________________________<br /> Policy Number:
   ________________________________<br /> Group Number:
   ________________________________<br /> Current Medical Issues:
   ________________________________<br /> <i>(include any mental,
      emotional &amp; physical issues)</i><br /> Current Treatments and
   Medications: ________________________________<br /> <i>(explain
      purpose of each)</i><br /> Allergies:
   ________________________________<br /> Any Activity Restrictions:
   ________________________________<br /> Hospitalizations:
   ________________________________<br /> Serious Illnesses/Injuries:
   ________________________________<br /> Chronic Disease:
   ________________________________<br /> Other Information:
   ________________________________
</p>
