<?php
// Params: $eventId
?>
<div class="results-list">
    <?php $this->Html->script('result_viewer', array('block' => 'secondaryScripts')); ?>
    <div id="list" class="result-list" data-result-list-url="<?= Configure::read('Rails.domain') ?>/iof/3.0/events/<?= $eventId ?>/result_list.xml">
        <div data-bind="foreach: courses">
            <h3 data-bind="text: name"></h3>
            <div data-bind="if: results().length == 0">
                <p><b>No results</b></p>
            </div>
            <div data-bind="if: results().length > 0">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Participant</th>
                            <th data-bind="visible: isScore">Score Points</th>
                            <th>Time</th>
                            <th data-bind="visible: isTimed">Points</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: results">
                        <tr>
                            <td data-bind="text: position || friendlyStatus"></td>
                            <td><a data-bind="attr: { href: person.profileUrl }"><span data-bind="text: person.givenName + ' ' + person.familyName"></span></a></td>
                            <td data-bind="visible: $parent.isScore, text: scores['Points']"></td>
                            <td data-bind="text: time != null ? hours + ':' + minutes + ':' + seconds + ($parent.millisecondTiming ? '.' + milliseconds : '' ) : ''"></td>
                            <td data-bind="visible: $parent.isTimed, text: scores['WhyJustRun']"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>