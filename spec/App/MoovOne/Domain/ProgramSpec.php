<?php

namespace spec\App\MoovOne\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\MoovOne\Domain;

class ProgramSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('propose', [
            Domain\ProgramId::generate(),
            'program',
            2
        ]);
    }

    function it_allows_participant_to_join_the_program()
    {
        $participant = new Domain\Participant(
            Domain\ParticipantId::generate(),
            'participant',
            Domain\Language::French()
        );
        $this->join($participant);

        $this->participants()->shouldHaveCount(1);
    }

    function it_forbids_already_participant_to_join_again()
    {
        $participant = new Domain\Participant(
            Domain\ParticipantId::generate(),
            'participant',
            Domain\Language::French()
        );

        $this->join($participant);

        $this->shouldThrow(new \InvalidArgumentException('Participant "participant" has already joined this program.'))->duringJoin($participant);
    }

    function it_forbids_too_many_participants_to_join()
    {
        $alice = new Domain\Participant(Domain\ParticipantId::generate(), 'alice', Domain\Language::French());
        $john = new Domain\Participant(Domain\ParticipantId::generate(), 'john', Domain\Language::French());
        $bob = new Domain\Participant(Domain\ParticipantId::generate(), 'bob', Domain\Language::French());

        $this->join($alice);
        $this->join($john);

        $this->shouldThrow(new \RuntimeException('The program "program" is already full'))->duringJoin($bob);
    }
}
