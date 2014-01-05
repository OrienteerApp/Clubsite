<?php
// Pass in array of $courses with associated results (actually registrations in this case)
// count($courses) should be > 0
assert(count($courses) > 0);
?>
<header>
    <h2>Course Registration</h2>
</header>
<div class="courses">
    <?php 
    $userId = $this->Session->read('Auth.User.id');
    $userId = empty($userId) ? 0 : $userId;
    foreach($courses as $course) { ?>
    <div class="course">
        <div class="course-info">
            <div class="pull-right">
                <?php if($course["registered"] === false) { ?>
                <div class="btn-group">
                    <a class="btn btn-success" href="/courses/register/<?= $course['id'] ?>/<?= $userId ?>"><span class="glyphicon glyphicon-plus"></span> Register</a>
                    <a class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/courses/register/<?= $course['id'] ?>/<?= $userId ?>/needsRide"><span class="glyphicon glyphicon-user"></span> Register (Need ride)</a></li>
                        <li><a href="/courses/register/<?= $course['id'] ?>/<?= $userId ?>/offeringRide"><span class="glyphicon glyphicon-road"></span> Register (Offer ride)</a></li>
                    </ul>
                </div>
                <?php } ?>
            </div>

            <h3><?= $course["name"] ?></h3>
            <span>
                <?= $course["description"] ?>
                <p>
                <?php
                if(!empty($course["distance"])) {
                echo "<br/><strong>Distance</strong>: ${course['distance']}m";
                }
                if(!empty($course["climb"])) {
                echo "<br/><strong>Climb</strong>: ${course['climb']}m";
                }
                ?>
                </p>
            </span>
        </div>
        <div class="results-list">
            <?php echo $this->element('Results/list', array('course' => $course, 'results' => $course["Result"])); ?>
        </div>
    </div>
    <?php } ?>
</div>

<?= $this->element('Events/register_others', array('courses' => $courses, 'userId' => $userId)) ?>
