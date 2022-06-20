<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2021/8/20 9:20
// +----------------------------------------------------------------------
namespace com\agf2\library\config\java\admin\template;

use com\agf2\abs\ConfAbs;

class HtmlConfig extends ConfAbs
{

    private string $index;
    private string $form;
    private string $formTabs;
    private string $view;

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getForm(): string
    {
        return $this->form;
    }

    /**
     * @param string $form
     */
    public function setForm(string $form): void
    {
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function getFormTabs(): string
    {
        return $this->formTabs;
    }

    /**
     * @param string $formTabs
     */
    public function setFormTabs(string $formTabs): void
    {
        $this->formTabs = $formTabs;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }
}
