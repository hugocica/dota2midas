<?php

    if(!isset($input['rarity'])){
        $input['rarity'][]='';
    }
    if(!isset($input['quality'])){
        $input['quality'][]='';
    }
    if(!isset($input['type'])){
        $input['type'][]='';
    }
    if(!isset($input['hero'])){
        $input['hero']='any';
    }

?>
<div class="row">
    <div class="col-sm-12">
        <div class="well well-sm">
            <form class="form-horizontal" method="get" action="{{action('TransactionController@index')}}">
              <div class="form-group">
                <label for="item" class="col-sm-1 control-label">Name</label>
                <div class="col-sm-11">
                  <input type="text" class="form-control" id="item"  name="item" placeholder="Name of the item">
                </div>
             </div>
            <div id="advanced-search" style="display: none">
                <div class="form-group">
                    <label for="hero" class="col-sm-1 control-label">Hero</label>
                     <div class="col-sm-11">
                         <select id="hero" name="hero" class="form-control">
                            <option {{($input['hero']=="any")?"selected":""}} value="any" >Any</option>
                            <option {{($input['hero']=="abaddon")?"selected":""}} value="abaddon">Abaddon</option>
                            <option {{($input['hero']=="alchemist")?"selected":""}} value="alchemist">Alchemist</option>
                            <option {{($input['hero']=="antimage")?"selected":""}} value="antimage">Anti-Mage</option>
                            <option {{($input['hero']=="axe")?"selected":""}} value="axe">Axe</option>
                            <option {{($input['hero']=="batrider")?"selected":""}} value="batrider">Batrider</option>
                            <option {{($input['hero']=="beastmaster")?"selected":""}} value="beastmaster">Beastmaster</option>
                            <option {{($input['hero']=="bloodseeker")?"selected":""}} value="bloodseeker">Bloodseeker</option>
                            <option {{($input['hero']=="bounty_hunter")?"selected":""}} value="bounty_hunter">Bounty Hunter</option>
                            <option {{($input['hero']=="brewmaster")?"selected":""}} value="brewmaster">Brewmaster</option>
                            <option {{($input['hero']=="bristleback")?"selected":""}} value="bristleback">Bristleback</option>
                            <option {{($input['hero']=="broodmother")?"selected":""}} value="broodmother">Broodmother</option>
                            <option {{($input['hero']=="centaur")?"selected":""}} value="centaur">Centaur Warrunner</option>
                            <option {{($input['hero']=="chaos_knight")?"selected":""}} value="chaos_knight">Chaos Knight</option>
                            <option {{($input['hero']=="chen")?"selected":""}} value="chen">Chen</option>
                            <option {{($input['hero']=="clinkz")?"selected":""}} value="clinkz">Clinkz</option>
                            <option {{($input['hero']=="rattletrap")?"selected":""}} value="rattletrap">Clockwerk</option>
                            <option {{($input['hero']=="crystal_maiden")?"selected":""}} value="crystal_maiden">Crystal Maiden</option>
                            <option {{($input['hero']=="dark_seer")?"selected":""}} value="dark_seer">Dark Seer</option>
                            <option {{($input['hero']=="dazzle")?"selected":""}} value="dazzle">Dazzle</option>
                            <option {{($input['hero']=="death_prophet")?"selected":""}} value="death_prophet">Death Prophet</option>
                            <option {{($input['hero']=="disruptor")?"selected":""}} value="disruptor">Disruptor</option>
                            <option {{($input['hero']=="doom_bringer")?"selected":""}} value="doom_bringer">Doom</option>
                            <option {{($input['hero']=="dragon_knight")?"selected":""}} value="dragon_knight">Dragon Knight</option>
                            <option {{($input['hero']=="drow_ranger")?"selected":""}} value="drow_ranger">Drow Ranger</option>
                            <option {{($input['hero']=="earth_spirit")?"selected":""}} value="earth_spirit">Earth Spirit</option>
                            <option {{($input['hero']=="earthshaker")?"selected":""}} value="earthshaker">Earthshaker</option>
                            <option {{($input['hero']=="elder_titan")?"selected":""}} value="elder_titan">Elder Titan</option>
                            <option {{($input['hero']=="ember_spirit")?"selected":""}} value="ember_spirit">Ember Spirit</option>
                            <option {{($input['hero']=="enchantress")?"selected":""}} value="enchantress">Enchantress</option>
                            <option {{($input['hero']=="enigma")?"selected":""}} value="enigma">Enigma</option>
                            <option {{($input['hero']=="faceless_void")?"selected":""}} value="faceless_void">Faceless Void</option>
                            <option {{($input['hero']=="gyrocopter")?"selected":""}} value="gyrocopter">Gyrocopter</option>
                            <option {{($input['hero']=="huskar")?"selected":""}} value="huskar">Huskar</option>
                            <option {{($input['hero']=="invoker")?"selected":""}} value="invoker">Invoker</option>
                            <option {{($input['hero']=="juggernaut")?"selected":""}} value="juggernaut">Juggernaut</option>
                            <option {{($input['hero']=="keeper_of_the_light")?"selected":""}} value="keeper_of_the_light">Keeper of the Light</option>
                            <option {{($input['hero']=="kunkka")?"selected":""}} value="kunkka">Kunkka</option>
                            <option {{($input['hero']=="legion_commander")?"selected":""}} value="legion_commander">Legion Commander</option>
                            <option {{($input['hero']=="leshrac")?"selected":""}} value="leshrac">Leshrac</option>
                            <option {{($input['hero']=="lich")?"selected":""}} value="lich">Lich</option>
                            <option {{($input['hero']=="life_stealer")?"selected":""}} value="life_stealer">Lifestealer</option>
                            <option {{($input['hero']=="lina")?"selected":""}} value="lina">Lina</option>
                            <option {{($input['hero']=="lion")?"selected":""}} value="lion">Lion</option>
                            <option {{($input['hero']=="lone_druid")?"selected":""}} value="lone_druid">Lone Druid</option>
                            <option {{($input['hero']=="luna")?"selected":""}} value="luna">Luna</option>
                            <option {{($input['hero']=="lycan")?"selected":""}} value="lycan">Lycan</option>
                            <option {{($input['hero']=="magnataur")?"selected":""}} value="magnataur">Magnus</option>
                            <option {{($input['hero']=="medusa")?"selected":""}} value="medusa">Medusa</option>
                            <option {{($input['hero']=="meepo")?"selected":""}} value="meepo">Meepo</option>
                            <option {{($input['hero']=="mirana")?"selected":""}} value="mirana">Mirana</option>
                            <option {{($input['hero']=="morphling")?"selected":""}} value="morphling">Morphling</option>
                            <option {{($input['hero']=="naga_siren")?"selected":""}} value="naga_siren">Naga Siren</option>
                            <option {{($input['hero']=="furion")?"selected":""}} value="furion">Nature's Prophet</option>
                            <option {{($input['hero']=="necrolyte")?"selected":""}} value="necrolyte">Necrophos</option>
                            <option {{($input['hero']=="nyx_assassin")?"selected":""}} value="nyx_assassin">Nyx Assassin</option>
                            <option {{($input['hero']=="ogre_magi")?"selected":""}} value="ogre_magi">Ogre Magi</option>
                            <option {{($input['hero']=="omniknight")?"selected":""}} value="omniknight">Omniknight</option>
                            <option {{($input['hero']=="obsidian_destroyer")?"selected":""}} value="obsidian_destroyer">Outworld Devourer</option>
                            <option {{($input['hero']=="phantom_assassin")?"selected":""}} value="phantom_assassin">Phantom Assassin</option>
                            <option {{($input['hero']=="phantom_lancer")?"selected":""}} value="phantom_lancer">Phantom Lancer</option>
                            <option {{($input['hero']=="puck")?"selected":""}} value="puck">Puck</option>
                            <option {{($input['hero']=="pudge")?"selected":""}} value="pudge">Pudge</option>
                            <option {{($input['hero']=="pugna")?"selected":""}} value="pugna">Pugna</option>
                            <option {{($input['hero']=="queenofpain")?"selected":""}} value="queenofpain">Queen of Pain</option>
                            <option {{($input['hero']=="razor")?"selected":""}} value="razor">Razor</option>
                            <option {{($input['hero']=="riki")?"selected":""}} value="riki">Riki</option>
                            <option {{($input['hero']=="rubick")?"selected":""}} value="rubick">Rubick</option>
                            <option {{($input['hero']=="sand_king")?"selected":""}} value="sand_king">Sand King</option>
                            <option {{($input['hero']=="shadow_demon")?"selected":""}} value="shadow_demon">Shadow Demon</option>
                            <option {{($input['hero']=="nevermore")?"selected":""}} value="nevermore">Shadow Fiend</option>
                            <option {{($input['hero']=="shadow_shaman")?"selected":""}} value="shadow_shaman">Shadow Shaman</option>
                            <option {{($input['hero']=="silencer")?"selected":""}} value="silencer">Silencer</option>
                            <option {{($input['hero']=="skywrath_mage")?"selected":""}} value="skywrath_mage">Skywrath Mage</option>
                            <option {{($input['hero']=="slardar")?"selected":""}} value="slardar">Slardar</option>
                            <option {{($input['hero']=="slark")?"selected":""}} value="slark">Slark</option>
                            <option {{($input['hero']=="sniper")?"selected":""}} value="sniper">Sniper</option>
                            <option {{($input['hero']=="spectre")?"selected":""}} value="spectre">Spectre</option>
                            <option {{($input['hero']=="spirit_breaker")?"selected":""}} value="spirit_breaker">Spirit Breaker</option>
                            <option {{($input['hero']=="storm_spirit")?"selected":""}} value="storm_spirit">Storm Spirit</option>
                            <option {{($input['hero']=="sven")?"selected":""}} value="sven">Sven</option>
                            <option {{($input['hero']=="techies")?"selected":""}} value="techies">Techies</option>
                            <option {{($input['hero']=="templar_assassin")?"selected":""}} value="templar_assassin">Templar Assassin</option>
                            <option {{($input['hero']=="terrorblade")?"selected":""}} value="terrorblade">Terrorblade</option>
                            <option {{($input['hero']=="tidehunter")?"selected":""}} value="tidehunter">Tidehunter</option>
                            <option {{($input['hero']=="timbersaw")?"selected":""}} value="timbersaw">Timbersaw</option>
                            <option {{($input['hero']=="tinker")?"selected":""}} value="tinker">Tinker</option>
                            <option {{($input['hero']=="tiny")?"selected":""}} value="tiny">Tiny</option>
                            <option {{($input['hero']=="treant")?"selected":""}} value="treant">Treant Protector</option>
                            <option {{($input['hero']=="tusk")?"selected":""}} value="tusk">Tusk</option>
                            <option {{($input['hero']=="undying")?"selected":""}} value="undying">Undying</option>
                            <option {{($input['hero']=="ursa")?"selected":""}} value="ursa">Ursa</option>
                            <option {{($input['hero']=="vengefulspirit")?"selected":""}} value="vengefulspirit">Vengeful Spirit</option>
                            <option {{($input['hero']=="venomancer")?"selected":""}} value="venomancer">Venomancer</option>
                            <option {{($input['hero']=="warlock")?"selected":""}} value="warlock">Warlock</option>
                            <option {{($input['hero']=="weaver")?"selected":""}} value="weaver">Weaver</option>
                            <option {{($input['hero']=="windrunner")?"selected":""}} value="windrunner">Windranger</option>
                            <option {{($input['hero']=="witch_doctor")?"selected":""}} value="witch_doctor">Witch Doctor</option>
                            <option {{($input['hero']=="skeleton_king")?"selected":""}} value="skeleton_king">Wraith King</option>
                         </select>
                     </div>
                </div>

                <div class="form-group">
                 <div class="col-sm-offset-2 col-sm-2">
                  <label for="quality" class="control-label">Quality</label>
                    <div>
                      <div  class="checkbox">
                        <label>
                            <input type="checkbox" id="quality[]" {{(in_array(9,$input['quality']))?'checked':''}}  name="quality[]" name="quality[]" value="9"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(9)}}"> {{\App\Helpers\DotaHelper::getQuality(9)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(20,$input['quality']))?'checked':''}}  name="quality[]" value="20"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(20)}}"> {{\App\Helpers\DotaHelper::getQuality(20)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(1,$input['quality']))?'checked':''}}  name="quality[]" value="1"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(1)}}"> {{\App\Helpers\DotaHelper::getQuality(1)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(12,$input['quality']))?'checked':''}}  name="quality[]" value="12"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(12)}}"> {{\App\Helpers\DotaHelper::getQuality(12)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(11,$input['quality']))?'checked':''}}  name="quality[]" value="11"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(11)}}"> {{\App\Helpers\DotaHelper::getQuality(11)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(18,$input['quality']))?'checked':''}}  name="quality[]" value="18"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(18)}}"> {{\App\Helpers\DotaHelper::getQuality(18)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                            <input type="checkbox" id="quality[]" {{(in_array(3,$input['quality']))?'checked':''}}  name="quality[]" value="3"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(3)}}"> {{\App\Helpers\DotaHelper::getQuality(3)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(19,$input['quality']))?'checked':''}}  name="quality[]" value="19"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(19)}}"> {{\App\Helpers\DotaHelper::getQuality(19)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(2,$input['quality']))?'checked':''}}  name="quality[]" value="2"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(2)}}"> {{\App\Helpers\DotaHelper::getQuality(2)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div >
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(17,$input['quality']))?'checked':''}}  name="quality[]" value="17"> <strong class="{{\App\Helpers\DotaHelper::getQualityCss(17)}}"> {{\App\Helpers\DotaHelper::getQuality(17)}}</strong>
                        </label>
                      </div>
                    </div>
                    <div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="quality[]" {{(in_array(16,$input['quality']))?'checked':''}}  name="quality[]" value="16"> <strong style="background-color: black;" class="{{\App\Helpers\DotaHelper::getQualityCss(16)}}"> {{\App\Helpers\DotaHelper::getQuality(16)}}</strong>
                        </label>
                      </div>
                    </div>
                   </div>
                   <div class=" col-sm-2">
                      <label for="rarity" class=" control-label">Rarity</label>
                          <div>
                            <div class="checkbox">
                              <label>
                                  <input type="checkbox" id="rarity[]" {{(in_array('common',$input['rarity']))?'checked':''}} name="rarity[]" name="rarity[]" value="common"> <strong class="common">Common</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("uncommon",$input['rarity']))?'checked':''}} name="rarity[]" value="uncommon"> <strong class="uncommon">Uncommon</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("rare",$input['rarity']))?'checked':''}} name="rarity[]" value="rare"> <strong class="rare">Rare</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("mythical",$input['rarity']))?'checked':''}} name="rarity[]" value="mythical"> <strong class="mythical">Mythical</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("legendary",$input['rarity']))?'checked':''}} name="rarity[]" value="legendary"> <strong class="legendary">Legendary</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("ancient",$input['rarity']))?'checked':''}} name="rarity[]" value="ancient"> <strong class="ancient">Ancient</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                  <input type="checkbox" id="rarity[]" {{(in_array("immortal",$input['rarity']))?'checked':''}} name="rarity[]" value="immortal"> <strong class="immortal">Immortal</strong>
                              </label>
                            </div>
                          </div>
                          <div>
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" id="rarity[]" {{(in_array("arcana",$input['rarity']))?'checked':''}} name="rarity[]" value="arcana"> <strong class="arcana">Arcana</strong>
                              </label>
                            </div>
                          </div>
                  </div>
                    <div class=" col-sm-2">
                        <label for="type" class=" control-label">Type</label>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Loading Screen",$input['type']))?'checked':''}} name="type[]"  value="Loading Screen"> <strong >Loading Screen</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Courier",$input['type']))?'checked':''}} name="type[]" value="Courier"> <strong >Courier</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Tool / Gem",$input['type']))?'checked':''}} name="type[]" value="Tool / Gem"> <strong>Gem / Rune</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Bundle",$input['type']))?'checked':''}} name="type[]" value="Bundle"> <strong >Bundle</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Ward",$input['type']))?'checked':''}} name="type[]" value="Ward"> <strong >Ward</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Cursor Pack",$input['type']))?'checked':''}} name="type[]" value="Cursor Pack"> <strong >Cursor Pack</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="type[]" {{(in_array("Tool",$input['type']))?'checked':''}} name="type[]" value="Tool"> <strong>Tool</strong>
                                </label>
                              </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("HUD Skin",$input['type']))?'checked':''}} name="type[]" value="HUD Skin"> <strong >HUD Skin</strong>
                                  </label>
                                </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Announcer",$input['type']))?'checked':''}} name="type[]" value="Announcer"> <strong >Announcer</strong>
                                  </label>
                                </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Treasure",$input['type']))?'checked':''}} name="type[]" value="Treasure"> <strong >Treasure</strong>
                                  </label>
                                </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Taunt",$input['type']))?'checked':''}} name="type[]" value="Taunt"> <strong >Taunt</strong>
                                  </label>
                                </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Music",$input['type']))?'checked':''}} name="type[]" value="Music"> <strong >Music</strong>
                                  </label>
                                </div>
                            </div>
                            <div>
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="type[]" {{(in_array("Misc",$input['type']))?'checked':''}} name="type[]" value="Misc"> <strong >Misc</strong>
                                  </label>
                                </div>
                            </div>
                        </div>
                </div>
             </div>
               <div class="form-group">
                <div class="col-sm-offset-1 col-sm-3">
                    <a id="advanced-search-btn" class="btn btn-sm btn-info" href="">Advanced search</a>
                    <a href="{{action('TransactionController@index')}}" class="btn btn-sm btn-success">Clear</a>

                </div>
                <div class="col-sm-offset-6 col-sm-2">
                      <button type="submit" class="btn btn-lg btn-primary">Search</button>
                </div>
              </div>


            </form>
        </div>
    </div>
</div>
<script>
$('#advanced-search-btn').click(function(e){
    e.preventDefault();
    $('#advanced-search').slideToggle('fast','swing');
});

</script>