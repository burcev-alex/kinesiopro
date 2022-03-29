<nav class="nav{{ $sufix }}">
    <ul class="navMenu{{ $sufix }} flex">
        <li class="navMenu__active">
            <a href="{{ route('about.us') }}"><span>О проекте</span></a>

            <ul class="navMenu{{ $sufix }}In">
                <li>
                    <a href="{{ route('about.organizations') }}">
                        <span>Основные сведения об образовательной организации</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('about.structure') }}">
                        <span>Структура и органы управления образовательной организацией</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('about.documents') }}">
                        <span>Документы</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('about.educations') }}">
                        <span>Образование</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('about.headliners') }}">
                        <span>Руководство. Педагогический (научно-педагогический) состав</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('about.materials') }}">
                        <span>Материально-техническое обеспечение и оснащенность образовательного
                            процесса</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="navMenu__program">
            <a href="{{ route('courses.index') }}"><span>Образовательные программы</span></a>
        </li>

        <li>
            <a href="/"><span>Преподаватели</span></a>
        </li>

        <li>
            <a href="{{ route('contacts') }}"><span>Контакты</span></a>
        </li>
    </ul>
</nav>
